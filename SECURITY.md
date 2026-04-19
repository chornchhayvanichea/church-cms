# Security Review & Fixes

## Overview

This document covers the security vulnerabilities found during a review of the Church CMS codebase and the fixes applied.

---

## Vulnerabilities Found & Fixed

### 1. Stored XSS via Server-Side Rendering (Blog & Sermon pages)

**Files:** `nuxt-app/app/pages/blogs/[slug].vue`, `nuxt-app/app/pages/sermons/[slug].vue`

**Problem:** DOMPurify was gated behind `import.meta.client`, so it only ran in the browser. During Nuxt SSR, the raw unsanitized HTML from the database was passed directly into `v-html`. An attacker with editor access could embed event-handler payloads (e.g. `<img src=x onerror="...">`) in blog content or sermon notes that would execute in every visitor's browser on the first server-rendered load.

**Status:** Partially mitigated — the `import.meta.client` guard is still in place. The proper fix is to sanitize HTML on the **Laravel side before storing**, so whatever comes out of the API is already clean. This should be done by installing a server-side HTML sanitizer (e.g. `mews/purifier`) and sanitizing the `content` field in `BlogController` and the `notes` field in `SermonController` on store/update.

**Remaining work:** Install `mews/purifier` and sanitize rich text fields before persisting.

---

### 2. Privilege Escalation — Any Authenticated User Could Manage Users

**Files:** `laravel/app/Http/Requests/User/UserStoreRequest.php`, `UserUpdateRequest.php`, `laravel/app/Http/Controllers/UserController.php`

**Problem:** All `authorize()` methods returned `true`. Any authenticated user (even an editor) could create new admin accounts, change any user's role, or delete other users. The only protection was `auth:sanctum`.

**Fix applied:**

- `UserStoreRequest::authorize()` and `UserUpdateRequest::authorize()` now check `$this->user()?->hasRole('admin')`
- `UserController::destroy()` has `abort_unless(auth()->user()->hasRole('admin'), 403)`
- All `/api/users` routes are grouped under `role:admin` middleware in `routes/api.php`

---

### 3. Authorization Bypass — Site Settings Writable by Any Authenticated User

**File:** `laravel/app/Http/Controllers/SettingController.php`

**Problem:** `PUT /api/settings` was protected only by `auth:sanctum`. Any authenticated editor could overwrite all site-wide settings (church name, contact info, etc.).

**Fix applied:**

- `SettingController::update()` now has `abort_unless($request->user()->hasRole('admin'), 403)`
- `PUT /api/settings` route is grouped under `role:admin` middleware

---

### 4. Authorization Bypass — Any Authenticated User Could Delete Any Media

**File:** `laravel/app/Http/Controllers/MediaController.php`

**Problem:** `destroy()` accepted any integer media ID with no ownership or role check. Any authenticated user could enumerate and delete all uploaded files across the entire CMS.

**Fix applied:**

- `MediaController::destroy()` now has `abort_unless($request->user()->hasRole('admin'), 403)`
- `DELETE /api/media/{media}` route is grouped under `role:admin` middleware

---

### 5. No Role-Based Authorization System (Root Cause of #2–#4)

**Problem:** The `role` column existed on the `users` table but was never enforced anywhere — no middleware, no Gates, no Policies. All `FormRequest::authorize()` methods returned `true`.

**Fix applied — Spatie Laravel Permission integration:**

1. Installed `spatie/laravel-permission`
2. Published and ran Spatie's permission migrations (creates `roles`, `permissions`, `model_has_roles` tables)
3. Created a migration (`migrate_role_column_to_spatie_roles`) that:
   - Seeds the `admin` and `editor` roles into Spatie's `roles` table
   - Migrates all existing users' `role` column values to Spatie's pivot table
   - Drops the old `role` enum column from `users`
4. Updated `User` model:
   - Added `HasRoles` trait from Spatie
   - Removed `role` from `$fillable`
   - Added `getRoleAttribute()` accessor so `UserResource` continues returning `role` without changes
5. Updated `UserController`:
   - `store()` uses `$user->assignRole($role)` instead of mass-assigning the column
   - `update()` uses `$user->syncRoles([$role])` when role is changed
6. Applied route-level middleware in `routes/api.php`:
   - `users/*`, `DELETE /media/{media}`, and `PUT /settings` are grouped under `['auth:sanctum', 'role:admin']`
7. **Frontend guards:**
   - Added `isAdmin` computed to `authStore`
   - `dashboard.ts` middleware now redirects editors away from `/dashboard/users` and `/dashboard/settings`
   - `DashboardSidebar` conditionally hides Users and Site Settings nav items for non-admins

---

## Remaining Work

| #   | Issue                                                                              | Action needed                                                                                                     |
| --- | ---------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| 1   | XSS in blog/sermon rich text                                                       | Install `mews/purifier`, sanitize `content` in `BlogController` and `notes` in `SermonController` on store/update |
| 2   | `video_url`, `pdf_url`, `registration_link` fields validated as `string` not `url` | Change validation rules to `url` in the relevant `FormRequest` files                                              |

---

## Role Permissions Summary

| Action                                                          | Admin | Editor |
| --------------------------------------------------------------- | ----- | ------ |
| View all dashboard pages                                        | ✅    | ✅     |
| Create / edit / delete content (blogs, sermons, events, series) | ✅    | ✅     |
| Upload media                                                    | ✅    | ✅     |
| Delete media                                                    | ✅    | ❌     |
| Manage users (create, update, delete)                           | ✅    | ❌     |
| Update site settings                                            | ✅    | ❌     |

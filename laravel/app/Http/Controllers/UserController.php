<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    private const USER_AVATAR = 'User/avatar';

    public function index(): AnonymousResourceCollection
    {
        $perPage = min((int) request()->get('per_page', 15), 100);

        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('role'),
            ])
            ->defaultSort('-created_at')
            ->paginate($perPage);

        return UserResource::collection($users);
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(UserStoreRequest $request): UserResource
    {
        $validated = $request->validated();
        $role = $validated['role'];
        unset($validated['role']);

        $user = User::create($validated);
        $user->assignRole($role);

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->toMediaCollection(self::USER_AVATAR);
        }

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $validated = $request->validated();

        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
            unset($validated['role']);
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection(self::USER_AVATAR);
            $user->addMediaFromRequest('avatar')
                ->toMediaCollection(self::USER_AVATAR);
        } elseif ($request->boolean('remove_avatar')) {
            $user->clearMediaCollection(self::USER_AVATAR);
        }

        $user->update($validated);

        return new UserResource($user);
    }

    public function destroy(User $user): JsonResponse
    {
        abort_unless(auth()->user()->hasRole('admin'), 403, 'Unauthorized.');
        $user->clearMediaCollection(self::USER_AVATAR);
        $user->delete();

        return response()->json(['message' => 'User has been deleted']);
    }
}

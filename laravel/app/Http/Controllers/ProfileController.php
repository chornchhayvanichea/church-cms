<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private const USER_AVATAR = 'User/avatar';

    public function update(Request $request): UserResource
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'email'    => ['sometimes', 'email', "unique:users,email,{$user->id}"],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'avatar'   => ['nullable', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120', 'sometimes'],
        ]);

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

        unset($validated['avatar']);
        $user->update($validated);

        return new UserResource($user);
    }
}

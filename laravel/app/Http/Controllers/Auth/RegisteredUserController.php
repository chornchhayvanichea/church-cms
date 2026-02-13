<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\FileHandling;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private const USER_IMAGE_DIR = 'User/images';

    public function store(Request $request, FileHandling $fileHandling): UserResource
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['nullable', 'mimes:png,jpeg,jpg,gif,webp', 'max:5126'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $fileHandling->uploadFile($request->file('image'), self::USER_IMAGE_DIR);
        }

        $user = User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
        ]);
        event(new Registered($user));

        Auth::login($user);

        return new UserResource($user);
    }
}

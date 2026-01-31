<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $loginRequest)
    {
        $credential = $loginRequest->validated();
        $user = User::where('email', $credential['email'])->first();
        if (! $user || Hash::check($credential['password'], $user->password)) {
            return response()->json([
                'message' => 'invalid credential provided',
            ]);
        }
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'message' => 'login successfully',
            'token' => $token,
        ]);
    }

    public function register(RegisterRequest $registerRequest)
    {
        $validated = $registerRequest->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['email']),
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'user created successfully',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'user has logged out',
        ]);
    }
}

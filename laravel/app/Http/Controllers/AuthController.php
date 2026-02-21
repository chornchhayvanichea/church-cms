<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'message' => 'credentials provided invalid.',
            ]);
        }
        $request->session()->regenerate();

        return response()->json([
            'message' => 'user has logged in successfully!',
            'success' => true,
        ]);
    }

    public function user(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function logout(): JsonResponse
    {
        Auth::guard('web')->logout();

        return response()->json([
            'message' => 'user has logged out successfully!',
        ]);
    }
}

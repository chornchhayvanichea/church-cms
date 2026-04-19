<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function publicIndex(): JsonResponse
    {
        $settings = Setting::all()->pluck('value', 'key');

        return response()->json(['data' => $settings]);
    }

    public function update(Request $request): JsonResponse
    {
        abort_unless($request->user()->hasRole('admin'), 403, 'Unauthorized.');

        $data = $request->validate([
            'settings' => ['required', 'array'],
            'settings.*' => ['nullable', 'string', 'max:1000'],
        ]);

        foreach ($data['settings'] as $key => $value) {
            Setting::set($key, $value);
        }

        $settings = Setting::all()->pluck('value', 'key');

        return response()->json(['data' => $settings, 'message' => 'Settings saved.']);
    }
}

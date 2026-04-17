<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\ContactSubmission;
use App\Models\Event;
use App\Models\Sermon;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactSubmission::create($data);

        return response()->json(['message' => 'Message sent successfully.']);
    }

    public function overview(): JsonResponse
    {
        return response()->json([
            'data' => [
                'blogs'   => Blog::count(),
                'sermons' => Sermon::count(),
                'events'  => Event::count(),
                'users'   => User::count(),
            ],
        ]);
    }
}

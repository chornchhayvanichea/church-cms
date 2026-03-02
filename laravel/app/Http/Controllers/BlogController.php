<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    private const BLOG_THUMBNAIL = 'Blog/thumbnail';

    public function show(Blog $blog): BlogResource
    {
        $blog->load('author');

        return new BlogResource($blog);
    }

    public function index(): AnonymousResourceCollection
    {
        return BlogResource::collection(Blog::with('author')->paginate(15));
    }

    public function store(BlogStoreRequest $request): BlogResource
    {
        $validated = $request->validated();

        $blog = Blog::create([
            ...$validated,
            'author_id' => Auth::id(),
        ]);
        if ($request->hasFile('thumbnail')) {
            $blog->addMediaFromRequest('thumbnail');
            $blog->toMediaCollection(self::BLOG_THUMBNAIL);
        }

        $blog->load('author');

        return new BlogResource($blog);
    }

    public function update(BlogUpdateRequest $request, Blog $blog): BlogResource
    {
        $validated = $request->validated();
        if ($request->hasFile('thumbnail')) {

            $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
            $blog->addMediaFromRequest('thumbnail');
            $blog->toMediaCollection(self::BLOG_THUMBNAIL);
        }
        if ($request->boolean('remove_file')) {
            $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
        }

        $blog->update($validated);
        $blog->load('author');

        return new BlogResource($blog);
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
        $blog->delete();

        return response()->json([
            'message' => 'Blog has been deleted successfully.',
        ]);
    }
}

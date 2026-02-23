<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Services\FileHandling;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    private const SERMON_THUMBNAIL = 'Sermon/thumbnail';

    public function show(Blog $blog): BlogResource
    {
        return new BlogResource($blog->with('author'));
    }

    public function index(): AnonymousResourceCollection
    {
        return BlogResource::collection(Blog::with('author')->paginate(15));
    }

    public function store(BlogStoreRequest $request, FileHandling $fileHandling): BlogResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $fileHandling->uploadFile($request->file('thumbnail'), self::SERMON_THUMBNAIL);
        }
        $blog = Blog::create([
            ...$validated,
            'author_id' => Auth::id(),
        ]);
        $blog->load('author');

        return new BlogResource($blog);
    }

    public function updaet(BlogUpdateRequest $request, FileHandling $fileHandling, Blog $blog): BlogResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) {
                $fileHandling->deleteFile($blog->thumbnail);
            }
            $validated['thumbnail'] = $fileHandling->uploadFile($request->file('thumbnail'), self::SERMON_THUMBNAIL);
        } elseif ($request->boolean('remove_file')) {
            if ($blog->thumbnail) {
                $fileHandling->deleteFile($blog->thumbnail);
            }
            $validated['thumbnail'] = null;
        }

        $blog->update($validated);
        $blog->load('author');

        return new BlogResource($blog);
    }

    public function destroy(Blog $blog, FileHandling $fileHandling)
    {
        if ($blog->thumbnail) {
            $fileHandling->deleteFile($blog->thumbnail);
        }
        $blog->delete();

        return response()->json([
            'message' => 'Blog has been deleted successfully.',
        ]);
    }
}

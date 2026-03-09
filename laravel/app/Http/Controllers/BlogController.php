<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            $blog->addMediaFromRequest('thumbnail')->toMediaCollection(self::BLOG_THUMBNAIL);
        }

        auth()->user()->getMedia('editor-temp')->each(function ($media) use ($blog) {
            $media->copy($blog, 'editor-images');
        });

        $blog->load('author');

        return new BlogResource($blog);
    }

    public function uploadEditorImage(Request $request): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:2048']);
        $media = auth()->user()->addMediaFromRequest('image')->toMediaCollection('editor-temp');

        return response()->json([
            'url' => $media->getUrl(),
            'media_id' => $media->id,
        ]);
    }

    public function update(blogupdaterequest $request, blog $blog): blogresource
    {
        $validated = $request->validated();
        if ($request->hasfile('thumbnail')) {

            $blog->clearmediacollection(self::BLOG_THUMBNAIL);
            $blog->addmediafromrequest('thumbnail');
            $blog->toMediaCollection(self::BLOG_THUMBNAIL);
        }
        if ($request->boolean('remove_file')) {
            $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
        }

        $oldMedia = $blog->getMedia('editor-images');
        foreach ($oldMedia as $media) {
            if (! str_contains($blog->content, $media->getUrl())) {
                $media->delete();
            }
        }

        $blog->update($validated);
        $blog->load('author');

        return new BlogResource($blog);
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
        $blog->clearMediaCollection('editor-images');
        $blog->delete();

        return response()->json([
            'message' => 'Blog has been deleted successfully.',
        ]);
    }
}

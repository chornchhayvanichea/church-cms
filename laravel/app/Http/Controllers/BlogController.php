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
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

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
        $blogs = QueryBuilder::for(Blog::class)
            ->with('author')
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('author_id'),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(['created_at', 'title', 'published_at'])
            ->paginate(15);

        return BlogResource::collection($blogs);
    }

    public function store(BlogStoreRequest $request): BlogResource
    {
        $validated = $request->validated();

        $blog = Blog::create([
            ...$validated,
            'author_id' => Auth::id(),
        ]);

        $blog->handleMediaUpload($request, 'thumbnail', self::BLOG_THUMBNAIL);

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
            'url' => '/storage/'.$media->id.'/'.$media->file_name,
            'media_id' => $media->id,
        ]);
    }

    public function update(BlogUpdateRequest $request, Blog $blog): BlogResource
    {
        $validated = $request->validated();
        if ($request->hasFile('thumbnail')) {
            $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
        } elseif ($request->boolean('remove_thumbnail')) {
            $blog->clearMediaCollection(self::BLOG_THUMBNAIL);
            $blog->thumbnail = null;
            $blog->save();
        }
        $blog->handleMediaUpload($request, 'thumbnail', self::BLOG_THUMBNAIL);

        $blog->update($validated);

        $oldMedia = $blog->getMedia('editor-images');
        foreach ($oldMedia as $media) {
            if (! str_contains($blog->content, $media->getUrl())) {
                $media->delete();
            }
        }

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

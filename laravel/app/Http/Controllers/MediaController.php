<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MediaController extends Controller
{
    private const MEDIA_COLLECTIONS = [
        'image' => 'Media/image',
        'audio' => 'Media/audio',
        'video' => 'Media/video',
    ];

    public function index(): AnonymousResourceCollection
    {
        $media = QueryBuilder::for(Media::class)
            ->allowedFilters([
                AllowedFilter::partial('mime_type'),
            ])
            ->paginate(30);

        return MediaResource::collection($media);
    }

    public function store(MediaRequest $request): MediaResource
    {
        $user = auth()->user();
        $media = $user->addMediaFromRequest('file')->toMediaCollection(self::MEDIA_COLLECTIONS[$request->collection]);

        return new MediaResource($media);
    }

    public function destroy(int $id, Request $request): JsonResponse
    {
        /*
           * another way to bind model from 3rd party package using this
           * Route::model('media', \Spatie\MediaLibrary\MediaCollections\Models\Media::class);
           */
        $media = Media::findOrFail($id);

        if (! $request->boolean('force')) {
            $inUse = Media::where('model_type', Blog::class)
                ->where('original_url', $media->original_url)
                ->exists()
                || Blog::where('thumbnail', $media->original_url)->exists();

            if ($inUse) {
                return response()->json([
                    'message' => 'Media is in use. Are you sure you want to delete it?',
                    'in_use' => true,
                ], 422);
            }
        }
        $media->delete();

        return response()->json([
            'message' => 'Media deleted successfully.',
        ]);
    }
}

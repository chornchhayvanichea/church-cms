<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Http\Resources\MediaResource;
use Illuminate\Http\JsonResponse;
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
        // TODO: pagination per media type (image/audio/video)
        // - pass type param to indexMediaApi
        // - filter in Laravel with mime_type like
        // - cache fetched state per type in store
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

    public function destroy(int $id): JsonResponse
    {
        /*
           * another way to bind model from 3rd party package using this
           * Route::model('media', \Spatie\MediaLibrary\MediaCollections\Models\Media::class);
           */
        $media = Media::findOrFail($id);
        $media->delete();

        return response()->json([
            'message' => 'Media deleted successfully.',
        ]);
    }
}

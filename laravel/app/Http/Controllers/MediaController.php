<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use App\Http\Resources\MediaResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    private const MEDIA_COLLECTIONS = [
        'image' => 'Media/image',
        'audio' => 'Media/audio',
        'video' => 'Media/video',
    ];

    public function index(): AnonymousResourceCollection
    {
        $media = Media::paginate(15);

        return MediaResource::collection($media);
    }

    public function store(MediaRequest $request): MediaResource
    {
        $user = auth()->user();
        $media = $user->addMediaFromRequest('file')->toMediaCollection(self::MEDIA_COLLECTIONS[$request->collection]);

        return new MediaResource($media);
    }

    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return response()->json(['message' => 'Media deleted successfully.']);
    }
}

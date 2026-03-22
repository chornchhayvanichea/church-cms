<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sermon\SermonStoreRequest;
use App\Http\Requests\Sermon\SermonUpdateRequest;
use App\Http\Resources\SermonResource;
use App\Models\Sermon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class SermonController extends Controller
{
    private const SERMON_THUMBNAIL = 'Sermon/thumbnail';

    private const SERMON_AUDIO = 'Sermon/audio';

    private const SERMON_VIDEO = 'Sermon/video';

    public function show(Sermon $sermon): SermonResource
    {
        return new SermonResource($sermon->load(['series', 'creator']));
    }

    public function index(): AnonymousResourceCollection
    {
        $sermons = Sermon::with('series')->paginate(15);

        return SermonResource::collection($sermons);
    }

    public function store(SermonStoreRequest $request): SermonResource
    {
        $validated = $request->validated();

        $sermon = Sermon::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);
        $sermon->handleMediaUpload($request, 'thumbnail', self::SERMON_THUMBNAIL);
        $sermon->handleMediaUpload($request, 'video', self::SERMON_VIDEO);
        $sermon->handleMediaUpload($request, 'audio', self::SERMON_AUDIO);
        $sermon->load('creator');

        return new SermonResource($sermon);
    }

    public function update(SermonUpdateRequest $request, Sermon $sermon): SermonResource
    {

        $validated = $request->validated();
        $fileFields = [
            'thumbnail' => self::SERMON_THUMBNAIL,
            'video' => self::SERMON_VIDEO,
            'audio' => self::SERMON_AUDIO,
        ];

        foreach ($fileFields as $field => $collection) {
            if ($request->hasFile($field)) {
                $sermon->clearMediaCollection($collection);
                $sermon->handleMediaUpload($request, $field, $collection);
            }
        }

        if ($request->hasFile('audio')) {
        }
        $sermon->update($validated);
        $sermon->load(['series', 'creator']);

        return new SermonResource($sermon);
    }

    public function destroy(Sermon $sermon): JsonResponse
    {

        $sermon->clearMediaCollection(self::SERMON_THUMBNAIL);
        $sermon->delete();

        return response()->json([
            'message' => 'sermon has been deleted',
            'success' => true,
        ]);
    }
}

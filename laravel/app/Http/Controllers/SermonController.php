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
        if ($request->hasFile('thumbnail')) {
            $sermon->addMediaFromRequest('thumbnail');
            $sermon->toMediaCollection(self::SERMON_THUMBNAIL);
        }
        $sermon->load('creator');

        return new SermonResource($sermon);
    }

    public function update(SermonUpdateRequest $request, Sermon $sermon): SermonResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $sermon->clearMediaCollection(self::SERMON_THUMBNAIL);
            $sermon->addMediaFromRequest('thumbnail');
            $sermon->toMediaCollection(self::SERMON_THUMBNAIL);
        }
        if ($request->boolean('remove_thumbnail')) {
            $sermon->clearMediaCollection(self::SERMON_THUMBNAIL);
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

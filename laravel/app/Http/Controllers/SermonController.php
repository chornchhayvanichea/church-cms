<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sermon\SermonStoreRequest;
use App\Http\Requests\Sermon\SermonUpdateRequest;
use App\Http\Resources\SermonResource;
use App\Models\Sermon;
use App\Services\FileHandling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SermonController extends Controller
{
    private const SERMON_DIR = 'Sermon/thumbnail';

    public function show(Sermon $sermon): SermonResource
    {
        return new SermonResource($sermon);
    }

    public function index(): AnonymousResourceCollection
    {
        $sermons = Sermon::with('series')->paginate(15);

        return SermonResource::collection($sermons);
    }

    public function store(SermonStoreRequest $request, FileHandling $fileHandling): SermonResource
    {
        $validated = $request->validated();
        $thumbnailPath = $fileHandling->uploadFile($request->file('thumbnail'), self::SERMON_DIR);
        if ($thumbnailPath) {
            $validated['thumbnail'] = $thumbnailPath;
        }
        $sermon = Sermon::create($validated);
        $sermon->load(['series', 'users']);

        return new SermonResource($sermon);
    }

    public function update(SermonUpdateRequest $request, Sermon $sermon, FileHandling $fileHandling): SermonResource
    {

        $validated = $request->validated();
        $thumbnailPath = $fileHandling->uploadFile($request->file('thumbnail'), self::SERMON_DIR);
        if ($thumbnailPath) {
            $fileHandling->deleteFile($sermon->thumbnail);
            $validated['thumbnail'] = $thumbnailPath;
        }
        $sermon->update($validated);

        return new SermonResource($sermon);
    }

    public function destroy(Sermon $sermon): JsonResponse
    {
        $sermon->delete();

        return response()->json([
            'message' => 'sermon has been deleted',
            'success' => true,
        ]);
    }
}

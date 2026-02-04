<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sermon\SermonStoreRequest;
use App\Http\Requests\Sermon\SermonUpdateRequest;
use App\Http\Resources\SermonResource;
use App\Models\Sermon;
use App\Services\FileHandling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

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

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $fileHandling->uploadFile($request->file('thumbnail'), self::SERMON_DIR);
        }

        $sermon = Sermon::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);
        $sermon->load(['series', 'creator']);

        return new SermonResource($sermon);
    }

    public function update(SermonUpdateRequest $request, Sermon $sermon, FileHandling $fileHandling): SermonResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($sermon->thumbnail) {
                $fileHandling->deleteFile($sermon->thumbnail);
            }
            $validated['thumbnail'] = $fileHandling->uploadFile($request->file('thumbnail'), self::SERMON_DIR);
        } elseif ($request->boolean('remove_thumbnail')) {
            if ($sermon->thumbnail) {
                $fileHandling->deleteFile($sermon->thumbnail);
            }
            $validated['thumbnail'] = null;
        }

        $sermon->update($validated);

        return new SermonResource($sermon);
    }

    public function destroy(Sermon $sermon, FileHandling $fileHandling): JsonResponse
    {
        if ($sermon->thumbnail) {
            $fileHandling->deleteFile($sermon->thumbnail);
        }
        $sermon->delete();

        return response()->json([
            'message' => 'sermon has been deleted',
            'success' => true,
        ]);
    }
}

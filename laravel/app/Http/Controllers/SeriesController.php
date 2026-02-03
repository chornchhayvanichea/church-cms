<?php

namespace App\Http\Controllers;

use App\Http\Requests\Series\SeriesStoreRequest;
use App\Http\Requests\Series\SeriesUpdateRequest;
use App\Http\Resources\SeriesResource;
use App\Models\Series;
use App\Services\FileHandling;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeriesController extends Controller
{
    private const SERIES_DIR = 'Series/thumbnails';

    public function index(): AnonymousResourceCollection
    {
        $series = Series::with('sermons')->paginate(15);

        return SeriesResource::collection($series);
    }

    public function show(Series $series): SeriesResource
    {
        return new SeriesResource($series);
    }

    public function store(SeriesStoreRequest $request, FileHandling $fileService): SeriesResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $fileService->uploadFile($request->file('thumbnail'), self::SERIES_DIR);
        }

        $series = Series::create($validated);

        return new SeriesResource($series);
    }

    public function update(SeriesUpdateRequest $request, FileHandling $fileService, Series $series): SeriesResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($series->thumbnail) {
                $fileService->deleteFile($series->thumbnail);
            }
            $validated['thumbnail'] = $fileService->uploadFile($request->file('thumbnail'), self::SERIES_DIR);
        } elseif ($request->boolean('remove_thumbnail')) {
            if ($series->thumbnail) {
                $fileService->deleteFile($series->thumbnail);
            }
            $validated['thumbnail'] = null;
        }
        $series->update($validated);

        return new SeriesResource($series);
    }

    public function destroy(Series $series)
    {
        $series->delete();

        return response()->json([
            'message' => 'series has been deleted',
        ]);
    }
}

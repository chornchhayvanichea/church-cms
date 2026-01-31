<?php

namespace App\Http\Controllers;

use App\Http\Requests\Series\SeriesRequest;
use App\Http\Resources\SeriesResource;
use App\Models\Series;
use App\Services\FileHandling;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeriesController extends Controller
{
    private const THUMBNAIL_DIR = 'Series/thumbnails';

    public function index(): AnonymousResourceCollection
    {
        $series = Series::with('sermons')->paginate(15);

        return SeriesResource::collection($series);
    }

    public function store(SeriesRequest $seriesRequest, FileHandling $fileService): SeriesResource
    {
        $validated = $seriesRequest->validated();

        $thumbnailPath = $fileService->uploadFile($seriesRequest->file('thumbnail'), self::THUMBNAIL_DIR);
        if ($thumbnailPath) {
            $validated['thumbnail'] = $thumbnailPath;
        }

        $series = Series::create($validated);

        return new SeriesResource($series);
    }

    public function update(SeriesRequest $seriesRequest, FileHandling $fileService, Series $series): SeriesResource
    {
        $validated = $seriesRequest->validated();
        $thumbnailPath = $fileService->uploadFile($seriesRequest->file('thumbnail'), self::THUMBNAIL_DIR);
        if ($thumbnailPath) {
            $validated['thumbnail'] = $thumbnailPath;
        }
        $series->update($validated);

        return new SeriesResource($series);
    }
}

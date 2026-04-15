<?php

namespace App\Http\Controllers;

use App\Http\Requests\Series\SeriesStoreRequest;
use App\Http\Requests\Series\SeriesUpdateRequest;
use App\Http\Resources\SeriesResource;
use App\Models\Series;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SeriesController extends Controller
{
    private const SERIES_THUMBNAIL = 'Series/thumbnails';

    public function index(): AnonymousResourceCollection
    {
        $series = Series::with('sermons')->paginate(15);

        return SeriesResource::collection($series);
    }

    public function show(Series $series): SeriesResource
    {
        return new SeriesResource($series->load('creator'));
    }

    public function store(SeriesStoreRequest $request): SeriesResource
    {
        $validated = $request->validated();

        $series = Series::create($validated);
        $series->handleMediaUpload($request, 'thumbnail', self::SERIES_THUMBNAIL);
        $series->load('creator');

        return new SeriesResource($series);
    }

    public function update(SeriesUpdateRequest $request, Series $series): SeriesResource
    {
        $validated = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $series->clearMediaCollection(self::SERIES_THUMBNAIL);
        } elseif ($request->boolean('remove_thumbnail')) {
            $series->clearMediaCollection(self::SERIES_THUMBNAIL);
            $series->thumbnail = null;
            $series->save();
        }
        $series->handleMediaUpload($request, 'thumbnail', self::SERIES_THUMBNAIL);
        $series->update($validated);
        $series->load('creator');

        return new SeriesResource($series);
    }

    public function destroy(Series $series): JsonResponse
    {
        $series->clearMediaCollection(self::SERIES_THUMBNAIL);

        $series->delete();

        return response()->json([
            'message' => 'series has been deleted',
        ]);
    }
}

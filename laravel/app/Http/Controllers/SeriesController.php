<?php

namespace App\Http\Controllers;

use App\Http\Requests\Series\SeriesStoreRequest;
use App\Http\Requests\Series\SeriesUpdateRequest;
use App\Http\Resources\SeriesResource;
use App\Models\Series;
use App\Models\Sermon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SeriesController extends Controller
{
    private const SERIES_THUMBNAIL = 'Series/thumbnails';

    public function index(): AnonymousResourceCollection
    {
        $perPage = min((int) request()->get('per_page', 15), 100);

        $series = QueryBuilder::for(Series::class)
            ->with('sermons')
            ->allowedFilters([AllowedFilter::partial('name')])
            ->defaultSort('-created_at')
            ->paginate($perPage);

        return SeriesResource::collection($series);
    }

    public function show(Series $series): SeriesResource
    {
        return new SeriesResource($series->load('sermons'));
    }

    public function store(SeriesStoreRequest $request): SeriesResource
    {
        $validated = $request->validated();

        $series = Series::create($validated);
        $series->handleMediaUpload($request, 'thumbnail', self::SERIES_THUMBNAIL);

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

        return new SeriesResource($series);
    }

    public function syncSermons(Request $request, Series $series): SeriesResource
    {
        $request->validate([
            'sermon_ids' => ['array'],
            'sermon_ids.*' => ['integer', 'exists:sermons,id'],
        ]);

        Sermon::where('series_id', $series->id)->update(['series_id' => null]);

        if (! empty($request->sermon_ids)) {
            Sermon::whereIn('id', $request->sermon_ids)->update(['series_id' => $series->id]);
        }

        return new SeriesResource($series->load('sermons'));
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

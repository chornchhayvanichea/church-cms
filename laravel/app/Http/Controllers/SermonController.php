<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sermon\SermonStoreRequest;
use App\Http\Requests\Sermon\SermonUpdateRequest;
use App\Http\Resources\SermonResource;
use App\Models\Sermon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SermonController extends Controller
{
    private const SERMON_THUMBNAIL = 'Sermon/thumbnail';

    private const SERMON_AUDIO = 'Sermon/audio';

    private const SERMON_VIDEO = 'Sermon/video';

    public function publicIndex(): AnonymousResourceCollection
    {
        $sermons = QueryBuilder::for(Sermon::class)
            ->with(['series', 'creator'])
            ->where('status', 'published')
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('series_id'),
            ])
            ->defaultSort('-published_at')
            ->paginate(12);

        return SermonResource::collection($sermons);
    }

    public function publicShow(Sermon $sermon): SermonResource
    {
        abort_if($sermon->status !== 'published', 404);

        return new SermonResource($sermon->load(['series', 'creator']));
    }

    public function show(Sermon $sermon): SermonResource
    {
        return new SermonResource($sermon->load(['series', 'creator']));
    }

    public function index(): AnonymousResourceCollection
    {
        $perPage = min((int) request()->get('per_page', 15), 100);

        $sermons = QueryBuilder::for(Sermon::class)
            ->with(['series', 'creator'])
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('status'),
                AllowedFilter::partial('speaker'),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(['created_at', 'title', 'sermon_date', 'speaker'])
            ->paginate($perPage);

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
            } elseif ($request->boolean('remove_'.$field)) {
                $sermon->clearMediaCollection($collection);
                $sermon->{$field} = null;
                $sermon->save();
            }
            $sermon->handleMediaUpload($request, $field, $collection);
        }

        $sermon->update($validated);
        $sermon->load(['series', 'creator']);

        return new SermonResource($sermon);
    }

    public function destroy(Sermon $sermon): JsonResponse
    {

        $sermon->clearMediaCollection(self::SERMON_THUMBNAIL);
        $sermon->clearMediaCollection(self::SERMON_AUDIO);
        $sermon->clearMediaCollection(self::SERMON_VIDEO);
        $sermon->delete();

        return response()->json([
            'message' => 'sermon has been deleted',
            'success' => true,
        ]);
    }
}

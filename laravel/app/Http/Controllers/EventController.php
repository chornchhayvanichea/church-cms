<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends Controller
{
    private const EVENT_IMAGE_DIR = 'Event/image';

    public function publicIndex(): AnonymousResourceCollection
    {
        $events = QueryBuilder::for(Event::class)
            ->where('status', 'upcoming')
            ->allowedFilters([AllowedFilter::partial('title')])
            ->defaultSort('event_date')
            ->paginate(12);

        return EventResource::collection($events);
    }

    public function show(Event $event): EventResource
    {
        $event->load('creator');

        return new EventResource($event);
    }

    public function index(): AnonymousResourceCollection
    {

        $events = QueryBuilder::for(Event::class)
            ->with('creator')
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('status'),
            ])
            ->defaultSort('-created_at')
            ->allowedSorts(['created_at', 'title', 'event_date'])
            ->paginate(15);

        return EventResource::collection($events);
    }

    public function store(EventStoreRequest $request): EventResource
    {
        $validated = $request->validated();

        $event = Event::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);
        $event->handleMediaUpload($request, 'image', self::EVENT_IMAGE_DIR);
        $event->load('creator');

        return new EventResource($event);
    }

    public function update(EventUpdateRequest $request, Event $event): EventResource
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $event->clearMediaCollection(self::EVENT_IMAGE_DIR);
        } elseif ($request->boolean('remove_image')) {
            $event->clearMediaCollection(self::EVENT_IMAGE_DIR);
            $event->image = null;
            $event->save();
        }
        $event->handleMediaUpload($request, 'image', self::EVENT_IMAGE_DIR);
        $event->update($validated);
        $event->load('creator');

        return new EventResource($event);
    }

    public function destroy(Event $event): JsonResponse
    {
        $event->clearMediaCollection(self::EVENT_IMAGE_DIR);
        $event->delete();

        return response()->json([
            'message' => 'event has been deleted successfully.',
        ]);
    }
}

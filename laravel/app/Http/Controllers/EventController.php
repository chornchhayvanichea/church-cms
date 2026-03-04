<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private const EVENT_IMAGE_DIR = 'Event/image';

    public function show(Event $event): EventResource
    {
        $event->load('creator');

        return new EventResource($event);
    }

    public function index(): AnonymousResourceCollection
    {

        $events = Event::with('creator')->paginate(15);

        return EventResource::collection($events);
    }

    public function store(EventStoreRequest $request): EventResource
    {
        $validated = $request->validated();

        $event = Event::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);
        if ($request->hasFile('image')) {
            $event->addMediaFromRequest('image');
            $event->toMediaCollection(self::EVENT_IMAGE_DIR);
        }
        $event->load('creator');

        return new EventResource($event);
    }

    public function update(EventUpdateRequest $request, Event $event): EventResource
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $event->clearMediaCollection(self::EVENT_IMAGE_DIR);
            $event->addMediaFromRequest('image');
            $event->toMediaCollection(self::EVENT_IMAGE_DIR);
        }

        if ($request->boolean('remove_file')) {
            $event->clearMediaCollection(self::EVENT_IMAGE_DIR);
        }
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

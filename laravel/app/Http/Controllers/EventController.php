<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\FileHandling;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private const EVENT_IMAGE_DIR = 'Event/image';

    public function show(Event $event): EventResource
    {
        return new EventResource($event);
    }

    public function index(): AnonymousResourceCollection
    {

        $events = Event::with('creator')->paginate(15);

        return EventResource::collection($events);
    }

    public function store(EventStoreRequest $request, FileHandling $fileHandling): EventResource
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $fileHandling->uploadFile($request->file('image'), self::EVENT_IMAGE_DIR);
        }
        $event = Event::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return new EventResource($event);
    }

    public function update(EventUpdateRequest $request, FileHandling $fileHandling, Event $event): EventResource
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($event->image) {
                $fileHandling->deleteFile($event->image);
            }
            $validated['image'] = $fileHandling->uploadFile($request->file('image'), self::EVENT_IMAGE_DIR);
        } elseif ($request->boolean('remove_file')) {
            if ($event->image) {
                $fileHandling->deleteFile($event->image);
            }
            $validated['image'] = null;
        }
        $event->update($validated);

        return new EventResource($event);
    }

    public function destroy(Event $event, FileHandling $fileHandling): JsonResponse
    {
        if ($event->image) {
            $fileHandling->deleteFile($event->image);
        }
        $event->delete();

        return response()->json([
            'message' => 'event has been deleted successfully.',
        ]);
    }
}

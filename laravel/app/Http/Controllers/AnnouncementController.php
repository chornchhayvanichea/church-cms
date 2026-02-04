<?php

namespace App\Http\Controllers;

use App\Http\Requests\Announcement\AnnouncementStoreRequest;
use App\Http\Requests\Announcement\AnnouncementUpdateRequest;
use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return AnnouncementResource::collection(Announcement::with('creator')->paginate(15));
    }

    public function show(Announcement $announcement): AnnouncementResource
    {
        return new AnnouncementResource($announcement->load('creator'));
    }

    public function store(AnnouncementStoreRequest $request): AnnouncementResource
    {
        $validated = $request->validated();
        $announcement = Announcement::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        $announcement->load('creator');

        return new AnnouncementResource($announcement);
    }

    public function update(AnnouncementUpdateRequest $request, Announcement $announcement): AnnouncementResource
    {
        $validated = $request->validated();
        $announcement->update($validated);
        $announcement->load('creator');

        return new AnnouncementResource($announcement);
    }

    public function destroy(Announcement $announcement): JsonResponse
    {
        $announcement->delete();

        return response()->json([
            'message' => 'Announcement has been deleted.',
        ]);
    }
}

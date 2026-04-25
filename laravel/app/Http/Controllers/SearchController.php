<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Event;
use App\Models\Sermon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json(['sermons' => [], 'blogs' => [], 'events' => []]);
        }

        $sermons = Sermon::where('status', 'published')
            ->where('title', 'like', "%{$q}%")
            ->orderByDesc('published_at')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'speaker']);

        $blogs = Blog::where('status', 'published')
            ->where('title', 'like', "%{$q}%")
            ->orderByDesc('published_at')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'excerpt']);

        $events = Event::where('title', 'like', "%{$q}%")
            ->orderByDesc('event_date')
            ->limit(5)
            ->get(['id', 'title', 'event_date', 'location']);

        return response()->json([
            'sermons' => $sermons->map(fn ($s) => [
                'title'    => $s->title,
                'slug'     => $s->slug,
                'subtitle' => $s->speaker,
            ]),
            'blogs' => $blogs->map(fn ($b) => [
                'title'    => $b->title,
                'slug'     => $b->slug,
                'subtitle' => $b->excerpt,
            ]),
            'events' => $events->map(fn ($e) => [
                'title'      => $e->title,
                'subtitle'   => $e->location,
                'event_date' => $e->event_date,
            ]),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Attendee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'published')
            ->select('id', 'title', 'cover_image', 'start_date')
            ->orderBy('start_date', 'asc')
            ->paginate(12);
        return view('attendee.events.index', compact('events'));
    }
}

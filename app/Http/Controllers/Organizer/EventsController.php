<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    public function create()
    {
        return view('organizer.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'venue' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Event::create([
            'organizer_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'venue' => $validated['venue'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'status' => 'draft',
        ]);

        return redirect()
            ->route('organizer.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function publish(int $id)
    {
        $event = Event::findOrFail($id);

        // Ensure the organizer owns this event
        if ($event->organizer_id !== Auth::id()) {
            abort(403);
        }

        $event->update([
            'status' => 'published',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Event published successfully!');
    }
}

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
        $user = Auth::user();

        if (!$user->roles()->where('name', 'organizer')->exists() || $user->active_role !== 'organizer') {
            abort(403);
        }

        return view('organizer.events.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->roles()->where('name', 'organizer')->exists() || $user->active_role !== 'organizer') {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'venue' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $coverImage = null;

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')
                                  ->store('events/covers', 'public');
        }

        Event::create([
            'organizer_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'venue' => $validated['venue'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'cover_image' => $coverImage,
            'status' => 'draft',
        ]);

        return redirect()->route('dashboard')
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

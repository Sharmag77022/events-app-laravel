<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if (! $user->hasOrganizerRole() || $user->active_role !== 'organizer') {
            abort(403);
        }

        return view('organizer.events.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (! $user->hasOrganizerRole() || $user->active_role !== 'organizer') {
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

    public function uploadTrixImage(Request $request)
    {
        $user = Auth::user();

        if (! $user->hasOrganizerRole() || $user->active_role !== 'organizer') {
            abort(403);
        }

        $validated = $request->validate([
            'attachment' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $path = $request->file('attachment')
            ->store('events/descriptions', 'public');

        return response()->json([
            'url' => url(Storage::url($path)),
        ]);
    }

    public function getEvents(Request $request)
    {
        $user = Auth::user();
        if (! $user->hasOrganizerRole() || $user->active_role !== 'organizer') {
            abort(403);
        }
        $query = Event::where('organizer_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest()->get();
    }

    public function publish(int $id)
    {
        $this->updateEvent($id, [
            'status' => 'published',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Event published successfully!');
    }

    public function draft(int $id)
    {
        $this->updateEvent($id, [
            'status' => 'draft',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Event saved as draft!');
    }

    public function update(int $id, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'venue' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')
                ->store('events/covers', 'public');
        }

        $this->updateEvent($id, $validated);

        return redirect()->route('dashboard')
            ->with('success', 'Event updated successfully!');
    }

    private function updateEvent(int $id, array $values)
    {
        $user = Auth::user();

        if (! $user->hasOrganizerRole() || $user->active_role !== 'organizer') {
            abort(403);
        }

        $event = Event::findOrFail($id);

        // Check whether this event belongs to the current organizer
        if ($event->organizer_id !== $user->id) {
            abort(403);
        }

        $event->update($values);

        return $event;
    }
}

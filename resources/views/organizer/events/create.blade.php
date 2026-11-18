
@extends('layouts.app')

@section('title', 'Create Event')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.umd.min.js"></script>
@endpush

@push('styles')
    <link rel="stylesheet"
          href="https://unpkg.com/trix@2.1.15/dist/trix.css">
@endpush

@section('content')

    <h1>Create Event</h1>
    <form 
        action="{{ route('organizer.events.store') }}"
        method="POST"
        enctype="multipart/form-data">
        @csrf

        <div>
            <label for="title">Event Title</label>
            <input type="text" name="title" id="title">
        </div>

        <div>
            <label for="cover_image">Cover Image</label>
            <input type="file" name="cover_image" id="cover_image">
        </div>

        <div>
            <label for="description">Event Description</label>

            <input type="hidden"
                   name="description"
                   id="description">

            <trix-editor input="description"></trix-editor>
        </div>

        <div>
            <label for="venue">Venue</label>
            <input type="text" name="venue" id="venue">
        </div>

        <div>
            <label for="start_date">Start Date</label>
            <input type="datetime-local"
                   name="start_date"
                   id="start_date">
        </div>

        <div>
            <label for="end_date">End Date</label>
            <input type="datetime-local"
                   name="end_date"
                   id="end_date">
        </div>

        <button type="submit">Create Event</button>

    </form>

@endsection

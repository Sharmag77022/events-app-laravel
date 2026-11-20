@extends('layouts.app')
@section('title', 'Organizer Dashboard')
@section('content')
<div>
    @foreach ($events as $event)
    {{ $event->title }}
    {{ $event->start_date }}
    {{ $event->cover_image }}
    @endforeach
</div>
@endsection

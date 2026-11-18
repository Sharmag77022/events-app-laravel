@extends('layouts.app')
@section('title', 'Attandee Dashboard')
@section('content')
<div>
    <h1>User Dashboard (Login Success)</h1>
    <br/>
    <br/>
    @if (Auth::user()->roles()->where('name', 'organizer')->exists())
        <a href="{{ route('dashboard.switch') }}">
            Switch to Organizer
        </a>
    @else
        <a href="{{ route('organizer.register') }}">
            Become an Organizer
        </a>
    @endif
</div>
@endsection

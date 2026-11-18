@extends('layouts.app')
@section('title', 'Organizer Dashboard')
@section('content')
<div>
    <h1>Organizer Dashboard</h1>
    <br/>
    <br/>
    <a href="{{route('dashboard.switch')}}">Switch to Attendee</a>
</div>
@endsection

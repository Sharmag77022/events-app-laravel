<div>
    <h1>Become an Organizer</h1>
    <form action="{{ route('organizer.store') }}" method="POST">
        @csrf
        <button type="submit">Become an Organizer</button>
    </form>
</div>

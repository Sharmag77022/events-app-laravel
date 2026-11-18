<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <title>@yield('title', 'Events App')</title>
    <!-- Common CSS -->
    @stack('styles')
</head>
<body>
    <!-- Common navigation can go here -->
    <header>
        <h2>Events App</h2>
    </header>
    <!-- Page-specific content -->
    <main>
        @yield('content')
    </main>
    <!-- Common JavaScript -->
</body>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('scripts')
</html>
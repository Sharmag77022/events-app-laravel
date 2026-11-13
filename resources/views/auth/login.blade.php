<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>

    <form action="{{ route('login-form') }}" method="POST">
        @csrf
        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <button type="submit">Login</button>
    </form>
    <p>
        Don't have an account?
        <a href="{{ route('signup-form') }}">Sign up</a>
    </p>

</body>
</html>
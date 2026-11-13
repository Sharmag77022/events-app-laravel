
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>

    <h1>Create an Account</h1>

    <form action="{{ route('signup-form') }}" method="POST">

        @csrf

        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}">

            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">

            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password">

            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit">Sign Up</button>

    </form>

</body>
</html>

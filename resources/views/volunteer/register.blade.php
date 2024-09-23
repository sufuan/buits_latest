<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Registration</title>
</head>

<body>
    @if (session('status'))
    <div style="color: green; font-weight: bold;">
        {{ session('status') }}
    </div>
    @endif

    <form action="{{ route('volunteer.register') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phone" placeholder="Phone">
        <!-- Add other fields as needed -->
        <button type="submit">Register</button>
    </form>
</body>

</html>
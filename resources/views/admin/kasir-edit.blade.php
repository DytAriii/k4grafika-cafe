<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasir</title>
</head>
<body>
    <h2>Edit Kasir</h2>
    <form method="POST" action="{{ route('kasir.update', $users->id) }}">
        @csrf
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="{{ $users->username }}" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="hidden" name="role" value="kasir">

        <button type="submit">Update</button>
    </form>
</body>
</html>
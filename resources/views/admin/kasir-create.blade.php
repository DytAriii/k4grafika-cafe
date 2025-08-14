<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kasir</title>
</head>
<body>
    <h2>Tambah Kasir</h2>
    <form method="POST" action="{{ route('kasir.store') }}">
        @csrf
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="hidden" name="role" value="kasir">

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
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
        @if($roles)
        <input type="hidden" name="roles_id" value="{{ $roles->id }}">
        @endif
        <button type="submit">Simpan</button>
    </form>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kasir</title>
    <link rel="stylesheet" href="{{ asset('css/edit-kasir.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Edit Kasir</h2>
        </div>

        <form method="POST" action="{{ route('kasir.update', $users->id) }}" class="form-container">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                       value="{{ $users->username }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="hidden" name="role" value="kasir">

            <div class="button-group">
                <a href="{{ route('daftarKasir') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Update</button>
            </div>
        </form>
    </div>
</body>
</html>

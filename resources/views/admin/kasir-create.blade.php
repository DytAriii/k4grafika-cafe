<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kasir</title>
    <link rel="stylesheet" href="{{ asset('css/tambah-kasir.css') }}">
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Tambah Kasir</h2>
        </div>

        <form method="POST" action="{{ route('kasir.store') }}" class="form-container">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            @if($roles)
            <input type="hidden" name="roles_id" value="{{ $roles->id }}">
            @endif

            <div class="button-group">
                <a href="{{ route('daftarKasir') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>

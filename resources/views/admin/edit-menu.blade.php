<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link rel="stylesheet" href="{{ asset('css/edit-menu.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Menu</h1>
        </div>

        <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ $menu->nama }}" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" name="harga" id="harga" value="{{ $menu->harga }}" step="any" required>
            </div>

            <div class="form-group">
                <label for="categories">Kategori</label>
                <select name="categories_id" id="categories" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $menu->categories_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="gambar">Gambar</label>
                @if($menu->gambar)
                    <div class="preview-img">
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}">
                    </div>
                @endif
                <input type="file" name="gambar" id="gambar" accept="image/*">
            </div>

            <div class="form-group">
                <label for="status_id">Status</label>
                <select name="status_id" id="status_id" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" {{ $menu->status_id == $status->id ? 'selected' : '' }}>
                            {{ $status->nama_status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="button-group">
                <a href="{{ route('manajemenMenu') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Update</button>
            </div>
        </form>
    </div>
</body>
</html>

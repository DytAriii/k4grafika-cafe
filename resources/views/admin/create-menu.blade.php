<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <link rel="stylesheet" href="{{ asset('css/create-menu.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tambah Menu</h1>
        </div>
        
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="nama" required>
            </div>
            
            <div class="form-row">
                <div class="form-group half">
                    <label>Category</label>
                    <select name="categories_id" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group half">
                    <label>Price</label>
                    <input type="number" name="harga" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Photo</label>
                <input type="file" name="gambar" accept="image/*" required>
            </div>
            
            <div class="form-group hidden">
                <select name="status_id" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="button-group">
                <a href="{{ route('manajemenMenu') }}" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>

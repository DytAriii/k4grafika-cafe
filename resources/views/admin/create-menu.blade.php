<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama Menu</label>
    <input type="text" name="nama" required>

    <label>Harga</label>
    <input type="number" name="harga" required>

    <label>Kategori</label>
    <select name="kategori_id" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <br>

    <label>Gambar:</label>
    <input type="file" name="gambar" accept="image/*" required>
    <br>

    <label>Status:</label>
    <select name="status" required>
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
    </select>
    <br>

    <button type="submit">Simpan</button>
</form>

<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Nama Menu</label>
    <input type="text" name="nama" required>

    <label>Harga</label>
    <input type="number" name="harga" required>

    <label>Kategori</label>
    <select name="categories_id" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
        @endforeach
    </select>
    <br>

    <label>Gambar:</label>
    <input type="file" name="gambar" accept="image/*" required>
    <br>

    <label>Status:</label>
    <select name="status_id" required>
        @foreach($statuses as $status)
        <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
    @endforeach
    </select>
    <br>

    <button type="submit">Simpan</button>
</form>

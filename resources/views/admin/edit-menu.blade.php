<form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" value="{{ $menu->nama }}" required>

    <label for="harga">Harga:</label>
    <input type="number" name="harga" id="harga" value="{{ $menu->harga }}" required>

    <label for="kategori">Kategori:</label>
    <select name="kategori" id="kategori" required>
        <option value="Drink" {{ $menu->kategori === 'Drink' ? 'selected' : '' }}>Drink</option>
        <option value="Coffee" {{ $menu->kategori === 'Coffee' ? 'selected' : '' }}>Coffee</option>
        <option value="Food" {{ $menu->kategori === 'Food' ? 'selected' : '' }}>Food</option>
        <option value="Snack" {{ $menu->kategori === 'Snack' ? 'selected' : '' }}>Snack</option>
    </select>

    <label for="gambar">Gambar:</label>
    <input type="file" name="gambar" id="gambar">

    <button type="submit">Update Menu</button>
</form>

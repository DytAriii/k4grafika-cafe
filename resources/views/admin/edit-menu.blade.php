<form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
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
    @if($menu->gambar)
    <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" width="100">
    @endif
    <input type="file" name="gambar" id="gambar">

    <select name="status" id="status">
        <option value="available" {{ $menu->status === 'available' ? 'selected' : '' }}>Available</option>
        <option value="unavailable" {{ $menu->status === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
    </select>
    <button type="submit">Update Menu</button>
</form>
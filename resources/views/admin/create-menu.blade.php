
<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Nama:</label>
    <input type="text" name="nama" required>
    <br>
    <label>Harga:</label>
    <input type="number" name="harga" required>
    <br>
    <label>Kategori:</label>
    <select name="kategori" required>
        <option value="Drink">Drink</option>
        <option value="Coffee">Coffee</option>
        <option value="Snack">Snack</option>
        <option value="Food">Food</option>
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
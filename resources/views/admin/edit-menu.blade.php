<form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" value="{{ $menu->nama }}" required>

    <label for="harga">Harga:</label>
    <input type="number" name="harga" id="harga" value="{{ $menu->harga }}" required>

    <label for="kategori">Kategori:</label>
<select name="kategori_id" id="kategori" required>
    @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ $menu->kategori_id == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>

    <label for="gambar">Gambar:</label>
    <input type="file" name="gambar" id="gambar">

    <label for="status">Status:</label>
<select name="status" id="status" required>
    <option value="On" {{ $menu->status == 'On' ? 'selected' : '' }}>On</option>
    <option value="Off" {{ $menu->status == 'Off' ? 'selected' : '' }}>Off</option>
</select>


    <button type="submit">Update Menu</button>
</form>

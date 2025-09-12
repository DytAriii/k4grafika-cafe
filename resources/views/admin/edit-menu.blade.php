<form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <label for="nama">Nama:</label>
    <input type="text" name="nama" id="nama" value="{{ $menu->nama }}" required>

    <label for="harga">Harga:</label>
    <input type="number" name="harga" id="harga" value="{{ $menu->harga }}" step="any" required>

    <label for="categories">Kategori:</label>
    <select name="categories_id" id="categories" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $menu->categories_id == $category->id ? 'selected' : '' }}>
                {{ $category->nama_category }}
            </option>
        @endforeach
    </select>

    <label for="gambar">Gambar:</label>
    @if($menu->gambar)
        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" width="100">
    @endif
    <input type="file" name="gambar" id="gambar">

    <label for="status_id">Status:</label>
    <select name="status_id" id="status_id" required>
        @foreach($statuses as $status)
            <option value="{{ $status->id }}" {{ $menu->status_id == $status->id ? 'selected' : '' }}>
                {{ $status->nama_status }}
            </option>
        @endforeach
    </select>

    <button type="submit">Update Menu</button>
</form>

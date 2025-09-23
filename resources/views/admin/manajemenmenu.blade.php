@extends('admin')

@section('content')
<div class="menu-container">
    <h1 class="page-title">Manajemen Menu</h1>

    {{-- Tombol Tambah Menu --}}
    <div class="menu-actions">
        <button class="btn btn-add" id="openModal">+ Tambah Menu</button>
    </div>

    {{-- Tabel Menu --}}
    <div class="table-wrapper">
        <table class="menu-table">
            <thead>
                <tr>
                    <th>Menu Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menu as $mn)
                <tr>
                    <td>{{ $mn->nama }}</td>
                    <td>{{ $mn->category->nama_category ?? '-' }}</td>
                    <td>Rp{{ number_format($mn->harga, 0, ',', '.') }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $mn->gambar) }}" alt="{{ $mn->nama }}" width="70">
                    </td>
                    <td class="action-buttons">
                        <button class="btn-edit" 
                            data-id="{{ $mn->id }}"
                            data-nama="{{ $mn->nama }}"
                            data-harga="{{ $mn->harga }}"
                            data-category="{{ $mn->categories_id }}"
                            data-status="{{ $mn->status_id }}"
                            data-gambar="{{ asset('storage/' . $mn->gambar) }}">
                            Edit
                        </button>

                        <a href="{{ route('menu.delete', $mn->id) }}" 
                           onclick="return confirm('Yakin ingin menghapus?')" 
                           class="btn-delete">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Menu --}}
<div id="menuModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Tambah Menu</h2>

        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            <div class="form-group">
                <label>Nama Menu</label>
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
                    <label>Harga</label>
                    <input type="number" name="harga" required>
                </div>
            </div>

            <div class="form-group">
                <label>Foto</label>
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
                <button type="button" class="btn-batal" id="closeModal2">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Menu --}}
<div id="editMenuModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeEditModal">&times;</span>
        <h2>Edit Menu</h2>

        <form id="editMenuForm" method="POST" enctype="multipart/form-data" class="form-container">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" id="editNama" required>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label>Category</label>
                    <select name="categories_id" id="editCategory" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group half">
                    <label>Harga</label>
                    <input type="number" name="harga" id="editHarga" required>
                </div>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <div class="preview-img" id="editPreviewImg"></div>
                <input type="file" name="gambar" accept="image/*">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status_id" id="editStatus" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="button-group">
                <button type="button" class="btn-batal" id="closeEditModal2">Batal</button>
                <button type="submit" class="btn-simpan">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('css/manajemenmenu.css') }}">
<link rel="stylesheet" href="{{ asset('css/create-menu.css') }}">

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}
.modal-content {
    background: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 15px;
    width: 50%;
    position: relative;
    animation: fadeIn 0.3s ease-in-out;
}
.close {
    position: absolute;
    right: 20px; top: 15px;
    font-size: 24px;
    cursor: pointer;
}
</style>

{{-- JS --}}
<script>
// Tambah Menu Modal
document.getElementById('openModal').onclick = () => {
    document.getElementById('menuModal').style.display = "block";
}
document.getElementById('closeModal').onclick = () => {
    document.getElementById('menuModal').style.display = "none";
}
document.getElementById('closeModal2').onclick = () => {
    document.getElementById('menuModal').style.display = "none";
}

// Edit Menu Modal
const editButtons = document.querySelectorAll('.btn-edit');
editButtons.forEach(btn => {
    btn.onclick = function() {
        let id = this.dataset.id;
        let nama = this.dataset.nama;
        let harga = this.dataset.harga;
        let category = this.dataset.category;
        let status = this.dataset.status;
        let gambar = this.dataset.gambar;

        // Isi form
        document.getElementById('editNama').value = nama;
        document.getElementById('editHarga').value = harga;
        document.getElementById('editCategory').value = category;
        document.getElementById('editStatus').value = status;

        // Gambar preview
        let preview = document.getElementById('editPreviewImg');
        preview.innerHTML = '<img src="'+gambar+'" width="100">';

        // Update action form
        document.getElementById('editMenuForm').action = '/admin/' + id + '/update-menu';

        // Tampilkan modal
        document.getElementById('editMenuModal').style.display = "block";
    }
});

document.getElementById('closeEditModal').onclick = () => {
    document.getElementById('editMenuModal').style.display = "none";
}
document.getElementById('closeEditModal2').onclick = () => {
    document.getElementById('editMenuModal').style.display = "none";
}
</script>
@endsection

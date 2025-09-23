@extends('admin')

@section('content')
<div class="kasir-container">
    {{-- Tombol Tambah Kasir --}}
    <div class="kasir-header">
        <button class="btn-tambah" onclick="openModal()">+ Tambah Kasir</button>
    </div>

    {{-- Tabel Kasir --}}
    <table class="kasir-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $usr)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $usr->username }}</td>
                <td>{{ $usr->name }}</td>
                <td class="aksi">
                    <button class="btn-edit" 
                            onclick="openEditModal('{{ $usr->id }}', '{{ $usr->username }}')">
                        Edit
                    </button>
                    <a href="{{ route('kasir.delete', $usr->id) }}" 
                       onclick="return confirm('Yakin ingin menghapus?')">
                        <button class="btn-delete">Hapus</button>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Tambah Kasir --}}
<div id="modalKasir" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>

        <h2>Tambah Kasir</h2>

        <form method="POST" action="{{ route('kasir.store') }}" class="form-container">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            @if($roles)
            <input type="hidden" name="roles_id" value="{{ $roles->id }}">
            @endif

            <div class="button-group">
                <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Kasir --}}
<div id="modalEditKasir" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>

        <h2>Edit Kasir</h2>

        <form id="editKasirForm" method="POST" class="form-container">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="edit_username">Username</label>
                <input type="text" id="edit_username" name="username" required>
            </div>

            <div class="form-group">
                <label for="edit_password">Password Baru</label>
                <input type="password" id="edit_password" name="password">
            </div>

            @if($roles)
            <input type="hidden" name="roles_id" value="{{ $roles->id }}">
            @endif

            <div class="button-group">
                <button type="button" class="btn-batal" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-simpan">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('css/daftarkasir.css') }}">
<link rel="stylesheet" href="{{ asset('css/tambah-kasir.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit-kasir.css') }}">

{{-- Script Modal --}}
<script>
    // Tambah Kasir
    function openModal() {
        document.getElementById('modalKasir').style.display = 'block';
    }
    function closeModal() {
        document.getElementById('modalKasir').style.display = 'none';
    }

    // Edit Kasir
    function openEditModal(id, username) {
        let modal = document.getElementById('modalEditKasir');
        let form = document.getElementById('editKasirForm');

        // ✅ set action sesuai route kasir.update
        form.action = "{{ route('kasir.update', ':id') }}".replace(':id', id);

        // Isi data username
        document.getElementById('edit_username').value = username;

        // Kosongkan password setiap buka modal
        document.getElementById('edit_password').value = "";

        modal.style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('modalEditKasir').style.display = 'none';
    }
</script>

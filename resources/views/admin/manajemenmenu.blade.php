@extends('admin')

@section('content')
<div class="menu-container">
    <h1 class="page-title">Manajemen Menu</h1>

    {{-- Tombol Tambah Menu --}}
    <div class="menu-actions">
        <a href="{{ route('menu.create') }}" class="btn btn-add">+ Tambah Menu</a>
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
                        <img src="{{ asset('storage/' . $mn->gambar) }}" 
                             alt="{{ $mn->nama }}">
                    </td>
                    <td class="action-buttons">
                        <a href="{{ route('menu.edit', $mn->id) }}" class="btn-edit">✏️</a>
                        <a href="{{ route('menu.delete', $mn->id) }}" 
                           onclick="return confirm('Yakin ingin menghapus?')" 
                           class="btn-delete">🗑️</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
{{-- panggil file css --}}
<link rel="stylesheet" href="{{ asset('css/manajemenmenu.css') }}">
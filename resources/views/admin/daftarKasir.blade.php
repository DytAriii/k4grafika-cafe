@extends('admin')

@section('content')
<div class="kasir-container">
    {{-- Tombol Tambah Kasir --}}
    <div class="kasir-header">
        <a href="{{ route('kasir.create') }}" class="btn-tambah">+ Tambah Kasir</a>
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
                    <a href="{{ route('kasir.edit', $usr->id) }}">
                        <button class="btn-edit">Edit</button>
                    </a>
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
@endsection

{{-- Panggil CSS --}}
<link rel="stylesheet" href="{{ asset('css/daftarkasir.css') }}">

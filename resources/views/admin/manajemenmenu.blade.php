@extends('admin')

@section('content')
<h1>Manajemen Menu</h1>

<h2>CRUD Menu</h2>

<a href="{{ route('menu.create') }}">
    <button>+ Tambah Menu</button>
</a>

<table border="1">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Gambar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($menu as $mn)
        <tr>
            <td>{{ $mn->nama }}</td>
            <td>{{ $mn->harga }}</td>
            <td>{{ $mn->category->nama ?? '-' }}</td>

            <td><img src="{{ asset('storage/' . $mn->gambar) }}" alt="{{ $mn->nama }}" width="100"></td>
            <td>

                <a href="{{ route('menu.delete', $mn->id) }}" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                <a href="{{ route('menu.edit', $mn->id) }}">Edit</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
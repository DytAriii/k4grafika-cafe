<div>
    <h2>CRUD Kasir</h2>

    <a href="{{ route('kasir.create') }}">
        <button>+ Tambah Kasir</button>
    </a>

    <a href="{{ route('logout') }}">
        <button>Logout</button>
    </a>
    
    <table border="1">
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $usr)
            <tr>
                <td>{{ $usr->username }}</td>
                <td style="overflow: auto;">{{ $usr->password }}</td>
                <td>{{ $usr->role }}</td>
                <td>
                    <a href="{{ route('kasir.edit', $usr->id) }}">Edit</a> |
                    <a href="{{ route('kasir.delete', $usr->id) }}" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div>
    <h2>CRUD Kasir</h2>

    <a href="{{ route('kasir.create') }}">
        <button>+ Tambah Kasir</button>
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
                    <a href="">Edit</a>|
                    <a href="">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
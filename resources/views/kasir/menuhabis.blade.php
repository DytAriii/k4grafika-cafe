@extends('layouts.app')

@section('onoffmenu')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
        vertical-align: middle;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    input:checked+.slider {
        background-color: #A74C29;
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }
</style>
<form action="{{ route('menuhabis.update') }}" method="POST">
    @csrf
    <div class="table-wrapper">
        <table class="menu-table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
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
                            alt="{{ $mn->nama }}" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td class="action-buttons">
                        <label class="switch">
                            <input type="hidden" name="status[{{ $mn->id }}]" value="2">
                            <input type="checkbox"
                                name="status[{{ $mn->id }}]"
                                value="1"
                                {{ $mn->status_id == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- <button type="submit" class="btn btn-primary" style="margin-top:16px;">Simpan</button> -->
</form>
<script>
document.querySelectorAll('input[type="checkbox"][name^="status"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function(e) {
        let isChecked = this.checked;
        let namaMenu = this.closest('tr').querySelector('td').innerText;
        let pesan = isChecked
            ? `Aktifkan menu "${namaMenu}"?`
            : `Tandai menu "${namaMenu}" sebagai habis?`;
        if (confirm(pesan)) {
            this.form.submit();
        } else {
            // Batalkan perubahan checkbox
            this.checked = !isChecked;
        }
    });
});
</script>
@endsection
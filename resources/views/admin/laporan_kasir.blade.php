@extends('admin')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasir</title>
    <link rel="stylesheet" href="{{ asset('css/laporan.css') }}">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Kasir</h1>
            <div class="filter">
                <form method="GET" action="{{ route('admin.laporan') }}">
                    <label for="kasir">Pilih Kasir:</label>
                    <select name="kasir" id="kasir" onchange="this.form.submit()">
                        @foreach($kasirs as $id => $nama)
                            <option value="{{ $id }}" {{ $id == $selectedKasir ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="info">
            <p><strong>Nama Kasir:</strong> {{ $laporan['nama'] }}</p>
            <p><strong>Jam Kerja:</strong> {{ $laporan['jam_kerja'] }}</p>
            <p><strong>Jumlah Transaksi:</strong> {{ $laporan['jumlah_transaksi'] }}</p>
        </div>

        <table class="laporan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Menu</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan['transaksi'] as $i => $trx)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $trx['invoice'] }}</td>
                        <td>{{ $trx['menu'] }}</td>
                        <td>{{ $trx['metode'] }}</td>
                        <td>{{ $trx['total'] }}</td>
                        <td>{{ $trx['waktu'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

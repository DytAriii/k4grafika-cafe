@extends('layouts.app')

@section('content')
<div class="harian-container">
    <div class="card">
        <p class="text-muted mb-2">Ringkasan total penjualan per hari</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                        <td>
                            Rp {{ number_format($row->total, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-muted">
                            Belum ada data penjualan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="total-summary mt-2">
            <strong>Total Keseluruhan:</strong> 
            <span class="highlight">
                Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}
            </span>
        </div>
    </div>
</div>
@endsection

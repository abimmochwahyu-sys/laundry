@extends('layouts.master')

@section('title', 'Laporan Owner')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Laporan Pendapatan</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Layanan</th>
                        <th>Berat (Kg)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>{{ $item->layanan->nama_layanan ?? '-' }}</td>
                            <td>{{ $item->berat_kg }}</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

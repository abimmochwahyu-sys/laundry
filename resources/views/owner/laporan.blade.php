@extends('layouts.master')

@section('title', 'Laporan Owner')

@section('content')

{{-- Header --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-800 mb-0">Laporan Pendapatan</h1>
</div>

<!-- {{-- Ringkasan Laporan --}}
<div class="row mb-4">

    {{-- Total Transaksi --}}
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-info text-white">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Total Transaksi
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        {{ $laporan->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Pendapatan --}}
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-success text-white">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Pendapatan
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        Rp {{ number_format($laporan->sum('total_harga'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rata-rata --}}
    <div class="col-md-4 mb-3">
        <div class="card shadow border-0 h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-primary text-white">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Rata-rata Pendapatan
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        Rp {{ number_format($laporan->avg('total_harga') ?? 0, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div> -->

<!-- </div> -->

{{-- Tabel Laporan --}}
<div class="card shadow-lg border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            📋 Detail Transaksi Laundry
        </h6>
        <span class="badge badge-primary px-3">
            {{ $laporan->count() }} Data
        </span>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-primary text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $item->layanan->jenis_layanan ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $item->berat }} Kg
                            </td>
                            <td class="font-weight-bold text-success">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Data laporan belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

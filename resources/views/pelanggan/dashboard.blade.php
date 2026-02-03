@extends('layouts.master')
@section('title', 'Dashboard Pelanggan')

@section('content')

{{-- STYLE --}}
<style>
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
</style>

<div class="container-fluid">

    {{-- HERO / WELCOME --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 text-white"
                 style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
                <div class="card-body py-4">
                    <h4 class="font-weight-bold mb-1">
                        Halo, {{ auth()->user()->name }} 👋
                    </h4>
                    <p class="mb-0">
                        Pantau status laundry dan riwayat transaksi Anda di sini.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row">

        {{-- Total Transaksi --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalTransaksi }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Menunggu Pembayaran --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning text-white">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Menunggu Pembayaran
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $transaksiPending }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Transaksi Selesai --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Transaksi Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $transaksiSelesai }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Pengeluaran --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-info text-white">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Pengeluaran
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPengeluaran,0,',','.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- TRANSAKSI TERBARU --}}
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold text-primary mb-0">
                🧾 Transaksi Terbaru
            </h6>
            <a href="{{ route('pelanggan.transaksi.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list mr-1"></i> Lihat Semua
            </a>
        </div>

        <div class="card-body">
            @if($transaksiTerbaru->count())
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Kode</th>
                                <th>Layanan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksiTerbaru as $trx)
                                <tr>
                                    <td class="font-weight-bold">
                                        {{ $trx->kode_transaksi }}
                                    </td>
                                    <td>
                                        {{ $trx->layanan->jenis_layanan }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $trx->status_pembayaran == 'lunas' ? 'badge-success' : 'badge-warning' }}">
                                            {{ ucfirst($trx->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="font-weight-bold text-success">
                                        Rp {{ number_format($trx->total_akhir,0,',','.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-4">
                    Belum ada transaksi
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

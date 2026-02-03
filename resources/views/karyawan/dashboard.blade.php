@extends('layouts.master')
@section('title', 'Dashboard Karyawan')

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
                        Selamat datang, {{ Auth::user()->name }} 👋
                    </h4>
                    <p class="mb-0">
                        Kelola dan pantau transaksi laundry pelanggan dengan mudah.
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
                        <div class="icon-circle bg-info text-white">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalTransaksi }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning text-white">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $pending }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Selesai --}}
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
                            Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $selesai }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Diambil --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-box-open"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Diambil
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $diambil }}
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
            <a href="{{ route('karyawan.transaksi.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list mr-1"></i> Lihat Semua
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                        <tr>
                            <td>{{ $transaksi->kode_transaksi }}</td>
                            <td>{{ $transaksi->user->name }}</td>
                            <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                            <td>
                                @if($transaksi->status_transaksi == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($transaksi->status_transaksi == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-info">Diambil</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Tidak ada data transaksi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

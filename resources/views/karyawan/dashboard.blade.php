@extends('layouts.master')
@section('title', 'Dashboard Karyawan')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Karyawan</h1>
    </div>

    <!-- Cards Row -->
    <div class="row">

        <!-- Total Transaksi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTransaksi }}</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending }}</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Selesai
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $selesai }}</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diambil -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Diambil
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $diambil }}</div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Transaksi Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Transaksi Terbaru</h6>
            <a href="{{ route('karyawan.transaksi.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-list mr-1"></i> Lihat Semua
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-light">
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
                                <td>{{ $transaksi->layanan->nama_layanan }}</td>
                                <td>
                                    @if($transaksi->status_transaksi == 'pending')
                                        <span class="badge bg-warning text-white">Pending</span>
                                    @elseif($transaksi->status_transaksi == 'selesai')
                                        <span class="badge bg-success text-white">Selesai</span>
                                    @elseif($transaksi->status_transaksi == 'diambil')
                                        <span class="badge bg-info text-white">Diambil</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            {{-- Kosong, footer ditampilkan --}}
                        @endforelse
                    </tbody>
                    @if($transaksis->isEmpty())
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-center text-gray-500">
                                    Tidak ada data transaksi.
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@extends('layouts.master')

@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
        <a href="{{ route('karyawan.transaksi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>
    
    <div class="row">
        <!-- Informasi Transaksi -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
                    <div>
                        <span class="badge 
                            @if($transaksi->status_transaksi == 'pending') bg-warning
                            @elseif($transaksi->status_transaksi == 'proses') bg-info
                            @elseif($transaksi->status_transaksi == 'selesai') bg-success
                            @elseif($transaksi->status_transaksi == 'diambil') bg-primary
                            @endif
                            text-white mr-2">
                            {{ strtoupper($transaksi->status_transaksi) }}
                        </span>
                        <span class="badge 
                            @if($transaksi->status_pembayaran == 'pending') bg-warning
                            @elseif($transaksi->status_pembayaran == 'lunas') bg-success
                            @endif
                            text-white">
                            {{ ucfirst($transaksi->status_pembayaran) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tr>
                                <th width="30%">Kode Transaksi</th>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>{{ $transaksi->user->name }} ({{ $transaksi->user->email }})</td>
                            </tr>
                            <tr>
                                <th>Jenis Layanan</th>
                                <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>{{ $transaksi->berat }} kg</td>
                            </tr>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <td>{{ is_object($transaksi->tanggal_transaksi) ? $transaksi->tanggal_transaksi->format('d F Y') : date('d F Y', strtotime($transaksi->tanggal_transaksi)) }}</td>
                            </tr>
                            <tr>
                                <th>Estimasi Selesai</th>
                                
                                <td>{{ $transaksi->layanan->estimasi_waktu }} hari</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                            </tr>
                            <tr>
                                <th>Status Pembayaran</th>
                                <td>
                                    <span class="badge 
                                        @if($transaksi->status_pembayaran == 'pending') bg-warning
                                        @elseif($transaksi->status_pembayaran == 'lunas') bg-success
                                        @endif
                                        text-white">
                                        {{ ucfirst($transaksi->status_pembayaran) }}
                                    </span>
                                </td>
                            </tr>
                            @if($transaksi->catatan)
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $transaksi->catatan }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rincian Biaya & Aksi -->
        <div class="col-md-4">
            <!-- Rincian Biaya -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Biaya</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td>Harga per Kg</td>
                                <td class="text-right">Rp {{ number_format($transaksi->layanan->harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Berat</td>
                                <td class="text-right">{{ $transaksi->berat }} kg</td>
                            </tr>
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            </tr>
                            @if($transaksi->diskon > 0)
                            <tr>
                                <td>Diskon</td>
                                <td class="text-right text-success">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr class="border-top">
                                <th>Total Bayar</th>
                                <th class="text-right text-primary">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Aksi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body text-center">
                    <!-- Edit Transaksi -->
                    <a href="{{ route('karyawan.transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit mr-1"></i> Edit Transaksi
                    </a>

                    <!-- Konfirmasi Pembayaran -->
                    @if($transaksi->status_pembayaran == 'pending')
                    <form action="{{ route('karyawan.transaksi.payment', $transaksi->id) }}" method="POST" class="d-inline mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check mr-1"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                    @endif

                    <!-- Tandai Lunas (jika status pembayaran belum lunas) -->
                    @if($transaksi->status_pembayaran != 'lunas')
                    <a href="{{ route('karyawan.transaksi.lunas', $transaksi->id) }}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-check-circle mr-1"></i> Tandai Lunas
                    </a>
                    @endif

                    <!-- Cetak Invoice -->
                    <a href="{{ route('karyawan.transaksi.invoice', $transaksi->id) }}" target="_blank" class="btn btn-primary btn-block">
                        <i class="fas fa-print mr-1"></i> Cetak Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

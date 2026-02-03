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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>

                    <div class="d-flex align-items-center">
                        {{-- Tombol Cetak Invoice --}}
                        <a href="{{ route('karyawan.transaksi.invoice', $transaksi->id) }}"
                           class="btn btn-sm btn-success mr-2"
                           target="_blank">
                            <i class="fas fa-print"></i> Cetak Invoice
                        </a>

                        {{-- Status Pembayaran --}}
                        <!-- <span class="badge 
                            @if($transaksi->status_pembayaran == 'pending') bg-warning 
                            @elseif($transaksi->status_pembayaran == 'lunas') bg-success 
                            @endif
                            text-white">
                            {{ ucfirst($transaksi->status_pembayaran) }}
                        </span> -->
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
                                <th>Jenis Layanan</th>
                                <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>{{ $transaksi->berat }} kg</td>
                            </tr>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <td>
                                    {{ $transaksi->tanggal_transaksi instanceof \Carbon\Carbon
                                        ? $transaksi->tanggal_transaksi->format('d F Y')
                                        : \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d F Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Estimasi Selesai</th>
                                <td>
                                    {{ $transaksi->tanggal_selesai
                                        ? (\Carbon\Carbon::parse($transaksi->tanggal_selesai)->format('d F Y'))
                                        : '-' }}
                                </td>
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
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rincian Biaya -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Biaya</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Harga per Kg</td>
                            <td class="text-right">
                                Rp {{ number_format($transaksi->layanan->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td>Berat</td>
                            <td class="text-right">{{ $transaksi->berat }} kg</td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-right">
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>

                        @if($transaksi->diskon > 0)
                        <tr>
                            <td>Diskon</td>
                            <td class="text-right text-success">
                                - Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endif

                        <tr class="border-top">
                            <th>Total Bayar</th>
                            <th class="text-right text-primary">
                                Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}
                            </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Transaksi -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Update Status Transaksi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('karyawan.transaksi.updateStatus', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="status_transaksi" class="form-label font-weight-bold">
                    Status Transaksi
                </label>
                <select class="form-control @error('status_transaksi') is-invalid @enderror"
                        id="status_transaksi"
                        name="status_transaksi"
                        required>
                    <option value="pending" {{ $transaksi->status_transaksi == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="selesai" {{ $transaksi->status_transaksi == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="diambil" {{ $transaksi->status_transaksi == 'diambil' ? 'selected' : '' }}>
                        Diambil
                    </option>
                </select>

                @error('status_transaksi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sync-alt mr-1"></i> Update Status
            </button>
        </form>
    </div>
</div>
@endsection

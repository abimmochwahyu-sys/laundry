@extends('layouts.master')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Transaksi</h1>
            <a href="{{ route('admin.transaksi.index') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.transaksi.update', $transaksi->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status_transaksi" class="form-label font-weight-bold">
                                        <i class="fas fa-tasks mr-1 text-primary"></i> Status Transaksi
                                    </label>
                                    <select class="form-control @error('status_transaksi') is-invalid @enderror"
                                        id="status_transaksi" name="status_transaksi" required>
                                        <option value="pending" {{ $transaksi->status_transaksi == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="proses" {{ $transaksi->status_transaksi == 'proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="selesai" {{ $transaksi->status_transaksi == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="diambil" {{ $transaksi->status_transaksi == 'diambil' ? 'selected' : '' }}>Diambil</option>
                                    </select>
                                    @error('status_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
<div class="col-md-6 mb-3">
    <label for="status_pembayaran" class="form-label font-weight-bold">
        <i class="fas fa-money-bill-wave mr-1 text-primary"></i> Status Pembayaran
    </label>
    <select class="form-control @error('status_pembayaran') is-invalid @enderror" 
        id="status_pembayaran" name="status_pembayaran" required>
        <option value="pending" {{ $transaksi->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="lunas" {{ $transaksi->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
    </select>
    @error('status_pembayaran')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_selesai" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-check mr-1 text-primary"></i> Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        id="tanggal_selesai" name="tanggal_selesai"
                                        value="{{ is_object($transaksi->tanggal_selesai) ? $transaksi->tanggal_selesai->format('Y-m-d') : date('Y-m-d', strtotime($transaksi->tanggal_selesai)) }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Update Transaksi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th>Kode Transaksi</th>
                                <td>: {{ $transaksi->kode_transaksi }}</td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>: {{ $transaksi->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Layanan</th>
                                <td>: {{ $transaksi->layanan->jenis_layanan }}</td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>: {{ $transaksi->berat }} kg</td>
                            </tr>
                            <tr>
                                <th>Total Bayar</th>
                                <td>: Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <td>:
                                    {{ is_object($transaksi->tanggal_transaksi) ? $transaksi->tanggal_transaksi->format('d/m/Y') : date('d/m/Y', strtotime($transaksi->tanggal_transaksi)) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Rincian Biaya</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
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
                                    <td class="text-right text-success">- Rp
                                        {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            <tr class="border-top">
                                <th>Total Bayar</th>
                                <th class="text-right text-primary">Rp
                                    {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
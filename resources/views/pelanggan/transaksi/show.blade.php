@extends('layouts.master')
@section('title', 'Detail Transaksi')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Transaksi</h1>
        <a href="{{ route('pelanggan.transaksi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="row">
        <!-- KIRI: Informasi Transaksi -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
                    <span class="badge
                        @if($transaksi->status_pembayaran == 'pending') bg-warning @endif
                        @if($transaksi->status_pembayaran == 'lunas') bg-success @endif
                        text-white">
                        {{ ucfirst($transaksi->status_pembayaran) }}
                    </span>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
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
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d F Y') }}</td>
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
                            <th>Status Transaksi</th>
                            <td>
                                <span class="badge
                                    @if($transaksi->status_transaksi == 'pending') bg-warning @endif
                                    @if($transaksi->status_transaksi == 'proses') bg-info @endif
                                    @if($transaksi->status_transaksi == 'selesai') bg-success @endif
                                    @if($transaksi->status_transaksi == 'diambil') bg-primary @endif
                                    text-white">
                                    {{ strtoupper($transaksi->status_transaksi) }}
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

        <!-- KANAN: Rincian Biaya & Aksi -->
        <div class="col-md-4">

            <!-- Rincian Biaya -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Biaya</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Harga per Kg</td>
                            <td class="text-right">Rp {{ number_format($transaksi->layanan->harga,0,',','.') }}</td>
                        </tr>
                        <tr>
                            <td>Berat</td>
                            <td class="text-right">{{ $transaksi->berat }} kg</td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-right">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</td>
                        </tr>
                        @if($transaksi->diskon > 0)
                        <tr>
                            <td>Diskon</td>
                            <td class="text-right text-success">- Rp {{ number_format($transaksi->diskon,0,',','.') }}</td>
                        </tr>
                        @endif
                        <tr class="border-top">
                            <th>Total Bayar</th>
                            <th class="text-right text-primary">Rp {{ number_format($transaksi->total_akhir,0,',','.') }}</th>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Pembayaran Online -->
            @if($transaksi->metode_pembayaran == 'midtrans' && $transaksi->status_pembayaran == 'pending')
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Pembayaran Online</h6>
                </div>
                <div class="card-body text-center">
                    <p class="mb-3">Silakan lanjutkan pembayaran menggunakan E-Wallet / QRIS / Transfer Bank</p>
                    <button id="pay-button" type="button" class="btn btn-success btn-block">
                        <i class="fas fa-credit-card mr-1"></i> Bayar Sekarang
                    </button>
                </div>
            </div>
            @endif

            <!-- Konfirmasi Pengambilan -->
            @if($transaksi->status_transaksi == 'selesai')
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body text-center">
                    <p class="mb-3">Laundry Anda sudah selesai dan siap diambil!</p>
                    <form action="{{ route('pelanggan.transaksi.pickup', $transaksi->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check mr-1"></i> Konfirmasi Pengambilan
                        </button>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($transaksi->metode_pembayaran == 'midtrans' && $transaksi->status_pembayaran == 'pending')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay('{{ $transaksi->snap_token }}', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                location.reload(); // refresh untuk update status
            },
            onPending: function(result) {
                alert('Pembayaran masih pending.');
            },
            onError: function(result) {
                alert('Pembayaran gagal, coba lagi.');
            }
        });
    });
</script>
@endif
@endpush

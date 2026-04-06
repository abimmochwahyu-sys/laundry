@extends('layouts.master')
@section('title', 'Cetak Laporan Transaksi')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Cetak Laporan Transaksi</h1>
            <p class="mb-0 text-muted">Periode: {{ request('start_date') ?? 'Semua' }} s/d {{ request('end_date') ?? 'Semua' }}</p>
        </div>
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak PDF
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center align-middle mb-0" id="print-report-table">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Total</th>
                            <th>Diskon</th>
                            <th>Akhir</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $index => $transaksi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                                <td>{{ $transaksi->user->name }}</td>
                                <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                                <td>{{ number_format($transaksi->berat, 2) }} Kg</td>
                                <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                                <td>{{ $transaksi->status_pembayaran === 'pending' ? 'Pending' : 'Lunas' }}</td>
                                <td>{{ ucfirst($transaksi->status_transaksi) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="font-weight-bold bg-light">
                        <tr>
                            <td colspan="6" class="text-right">TOTAL</td>
                            <td>Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksis->sum('diskon'), 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksis->sum('total_akhir'), 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .breadcrumb, .card-header, button, .no-print, .pagination {
                display: none !important;
            }
        }
    </style>
@endsection

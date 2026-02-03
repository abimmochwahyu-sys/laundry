@extends('layouts.master')
@section('title', 'Laporan Transaksi')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Laporan Transaksi</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date"
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date"
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="font-weight-bold">📊 Data Laporan Transaksi</h6>
            <a href="{{ route('admin.laporan.export', request()->all()) }}"
               class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
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
                            <th>Aksi</th> {{-- ✅ BARU --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $index => $transaksi)
                        <tr>
                            <td>{{ $index + $transaksis->firstItem() }}</td>
                            <td>
                                <span class="badge badge-dark">
                                    {{ $transaksi->kode_transaksi }}
                                </span>
                            </td>
                            <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                            <td>{{ $transaksi->user->name }}</td>
                            <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                            <td>{{ number_format($transaksi->berat, 2) }} Kg</td>
                            <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                            <td><strong>Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</strong></td>
                            <td>
                                @if($transaksi->status_pembayaran == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-success">Lunas</span>
                                @endif
                            </td>
                            <td>
                                @if($transaksi->status_transaksi == 'pending')
                                    <span class="badge badge-secondary">Pending</span>
                                @elseif($transaksi->status_transaksi == 'proses')
                                    <span class="badge badge-info">Proses</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.laporan.invoice', $transaksi->id) }}"
                                   class="btn btn-primary btn-sm"
                                   target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="font-weight-bold bg-light">
                        <tr>
                            <td colspan="6" class="text-right">TOTAL</td>
                            <td>Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksis->sum('diskon'), 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksis->sum('total_akhir'), 0, ',', '.') }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-3">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
@endsection

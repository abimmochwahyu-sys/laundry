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
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold">📊 Data Laporan Transaksi</h6>
            <div>
                <a href="{{ route('admin.laporan.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
        <div class="card shadow-sm">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat (Kg)</th>
                                <th>Total Harga</th>
                                <th>Diskon</th>
                                <th>Total Akhir</th>
                                <th>Status Pembayaran</th>
                                <th>Status Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $index => $transaksi)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge badge-dark">{{ $transaksi->kode_transaksi }}</span></td>
                                    <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                                    <td>{{ $transaksi->user->name }}</td>
                                    <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                                    <td>{{ number_format($transaksi->berat, 2) }}</td>
                                    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                                    <td><strong>Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</strong></td>
                                    <td>
                                        @if($transaksi->status_pembayaran == 'pending')
                                            <span class="badge badge-warning px-3">Pending</span>
                                        @else
                                            <span class="badge badge-success px-3">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaksi->status_transaksi == 'pending')
                                            <span class="badge badge-secondary px-3">Pending</span>
                                        @elseif($transaksi->status_transaksi == 'proses')
                                            <span class="badge badge-info px-3">Diproses</span>
                                        @else
                                            <span class="badge badge-success px-3">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light font-weight-bold">
                            <tr>
                                <td colspan="6" class="text-right">Total:</td>
                                <td>Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaksis->sum('diskon'), 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaksis->sum('total_akhir'), 0, ',', '.') }}</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
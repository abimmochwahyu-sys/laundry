@extends('layouts.master')
@section('title', 'Daftar Transaksi')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi</h1>
        <a href="{{ route('pelanggan.transaksi.create') }}"
           class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Transaksi Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
        </div>

        <div class="card-body">
            @if($transaksis->count())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transaksis as $transaksi)
                            <tr>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                                <td>{{ $transaksi->berat }} kg</td>
                                <td>Rp {{ number_format($transaksi->total_akhir,0,',','.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $transaksi->status_pembayaran == 'lunas' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($transaksi->status_pembayaran) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pelanggan.transaksi.show', $transaksi->id) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $transaksis->links() }}
            @else
                <div class="text-center py-5">
                    <h5 class="text-muted">Belum ada transaksi</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

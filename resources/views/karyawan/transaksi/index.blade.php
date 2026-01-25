@extends('layouts.master')
@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Transaksi</h1>
            <a href="{{ route('karyawan.transaksi.create') }}"
                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Buat Transaksi Baru
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi</h6>
            </div>
            <div class="card-body">
                @if($transaksis->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Layanan</th>
                                    <th>Berat</th>
                                    <th>Total Bayar</th>
                                    <th>Tanggal Transaksi</th>
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
                                                <td>Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                                                <td>
                                                    @php
                                                        if (is_object($transaksi->tanggal_transaksi) && method_exists($transaksi->tanggal_transaksi, 'format')) {
                                                            $tanggal = $transaksi->tanggal_transaksi->format('d/m/Y');
                                                        } else {
                                                            $tanggal = date('d/m/Y', strtotime($transaksi->tanggal_transaksi));
                                                        }
                                                    @endphp
                                                    {{ $tanggal }}
                                                </td>
                                                <td>
                                                    <span class="badge 
                                    @if($transaksi->status_transaksi == 'pending') bg-warning @endif
                                    @if($transaksi->status_transaksi == 'selesai') bg-success @endif
                                    @if($transaksi->status_transaksi == 'diambil') bg-primary @endif
                                    text-white">
                                                        {{ ucfirst($transaksi->status_transaksi) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <a href="{{ route('karyawan.transaksi.show', $transaksi->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $transaksis->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-receipt fa-3x text-gray-300 mb-3"></i>
                        <h5 class="text-gray-500">Belum ada transaksi</h5>
                        <a href="{{ route('karyawan.transaksi.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Buat Transaksi Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
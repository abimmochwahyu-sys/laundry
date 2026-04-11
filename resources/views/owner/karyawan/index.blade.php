@extends('layouts.master')

@section('title', 'Data Karyawan')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Data Karyawan</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Karyawan (Read-Only)</h6>
                <div class="dropdown no-arrow">
                    <a href="{{ route('owner.karyawan.export.excel') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel fa-sm fa-fw mr-1"></i> Export Excel
                    </a>
                    <a href="{{ route('owner.karyawan.export.pdf') }}" class="btn btn-danger btn-sm" target="_blank">
                        <i class="fas fa-file-pdf fa-sm fa-fw mr-1"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $karyawan->user->name ?? 'N/A' }}</td>
                                    <td>{{ $karyawan->user->email ?? 'N/A' }}</td>
                                    <td>{{ $karyawan->alamat }}</td>
                                    <td>{{ $karyawan->telepon }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data karyawan belum ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

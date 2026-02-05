@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('content')

{{-- STYLE --}}
<style>
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
</style>

<div class="container-fluid">

    {{-- HEADER / WELCOME --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 text-white"
                 style="background: linear-gradient(135deg, #4e73df, #36b9cc);">
                <div class="card-body py-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-1">
                            Selamat Datang, {{ auth()->user()->name }} 👋
                        </h4>
                        <p class="mb-0">
                            Kelola data laundry dan pantau performa bisnis Anda
                        </p>
                    </div>
                    <span class="badge badge-light text-dark p-2">
                        {{ now()->format('l, d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="row">

        {{-- Karyawan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary text-white">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Karyawan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahKaryawan }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pelanggan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-success text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahPelanggan }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Layanan --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-info text-white">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Jenis Layanan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahLayanan }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Transaksi --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning text-white">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahTransaksi }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- PENDAPATAN & QUICK ACTION --}}
    <div class="row">

        {{-- Total Pendapatan --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase">Total Pendapatan</h6>
                    <h2 class="font-weight-bold text-success mt-2">
                        Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                    </h2>
                    <p class="text-muted mb-0">
                        Akumulasi seluruh transaksi yang masuk
                    </p>
                </div>
            </div>
        </div>

        {{-- Quick Action --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted mb-3">Quick Action</h6>

                    <a href="{{ route('admin.karyawan.index') }}"
                       class="btn btn-warning btn-sm mb-2">
                        <i class="fas fa-receipt"></i> Daftar Karyawan
                    </a>
                    <a href="{{ route('admin.pelanggan.index') }}"
                       class="btn btn-primary btn-sm mb-2">
                        <i class="fas fa-receipt"></i> Daftar Pelanggan
                    </a>
                    <br>
                    <a href="{{ route('admin.layanan.index') }}"
                       class="btn btn-success btn-sm mb-2">
                        <i class="fas fa-receipt"></i> Kelola Layanan
                    </a>

                    {{-- <br> --}}

                    <a href="{{ route('admin.laporan.index') }}"
                       class="btn btn-dark btn-sm mb-2">
                        <i class="fas fa-file-alt"></i> Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

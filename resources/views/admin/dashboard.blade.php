@extends('layouts.master')
@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

{{-- ADMIN --}}
@if(auth()->user()->role === 'admin')

<div class="card shadow mb-4">
    <div class="card-body">
        Selamat datang Admin <strong>{{ auth()->user()->name }}</strong> 🚀
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary mb-1">
                    Data Pelanggan
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $jumlahPelanggan ?? 0 }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- KARYAWAN --}}
@elseif(auth()->user()->role === 'karyawan')

<div class="card shadow mb-4">
    <div class="card-body">
        Selamat datang Karyawan <strong>{{ auth()->user()->name }}</strong> 👷
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success mb-1">
                    Transaksi Hari Ini
                </div>
                <div class="h5 font-weight-bold text-gray-800">
                    {{ $transaksiHariIni ?? 0 }}
                </div>
            </div>
        </div>
    </div>
</div>

@endif
@endsection

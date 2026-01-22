@extends('layouts.master')

@section('title', 'Dashboard Owner')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Owner</h1>

{{-- Welcome Card --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-body">
                <h5 class="font-weight-bold text-primary">
                    Selamat datang, {{ Auth::user()->name }} 👋
                </h5>
                <p class="mb-0 text-muted">
                    Anda login sebagai <strong>Owner</strong>.  
                    Di halaman ini Anda dapat memantau performa bisnis laundry.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Statistik Ringkas --}}
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    Total Pendapatan
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    Total Transaksi
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $totalTransaksi ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    Transaksi Proses
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $transaksiProses ?? 0 }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                    Jumlah Karyawan
                </div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ $totalKaryawan ?? 0 }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const loginSuccess = localStorage.getItem('loginSuccess');

    if (loginSuccess === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            text: 'Selamat datang di Dashboard Owner SICLEAN',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });

        localStorage.removeItem('loginSuccess');
    }

});
</script>
@endpush

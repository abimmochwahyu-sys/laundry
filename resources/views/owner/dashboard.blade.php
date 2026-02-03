@extends('layouts.master')

@section('title', 'Dashboard Owner')

@section('content')

{{-- Header --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-800 mb-0">Dashboard Owner</h1>
    <span class="badge badge-primary px-3 py-2 shadow-sm">
        SICLEAN Laundry System
    </span>
</div>

{{-- Hero / Welcome --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-lg border-0 text-white"
             style="background: linear-gradient(135deg, #4e73df, #1cc88a);">
            <div class="card-body py-4">
                <h4 class="font-weight-bold mb-1">
                    Selamat datang, {{ Auth::user()->name }} 👋
                </h4>
                <p class="mb-0">
                    Pantau performa bisnis laundry Anda secara real-time dan akurat.
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="row">

    {{-- Pendapatan --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-success text-white">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Total Pendapatan
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
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
                    <div class="icon-circle bg-info text-white">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Total Transaksi
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $totalTransaksi ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Proses --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-warning text-white">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                </div>
                <div>
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Transaksi Proses
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $transaksiProses ?? 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Karyawan --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 border-0">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <div class="icon-circle bg-secondary text-white">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div>
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

</div>

{{-- Chart --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    📈 Grafik Pendapatan Bulanan
                </h6>
            </div>
            <div class="card-body">
                <canvas id="dashboardChart" height="90"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // SweetAlert Login
    const loginSuccess = localStorage.getItem('loginSuccess');
    if (loginSuccess === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil!',
            text: 'Selamat datang di Dashboard Owner SICLEAN',
            showConfirmButton: false,
            timer: 3000,
            toast: true,
            position: 'top-end'
        });
        localStorage.removeItem('loginSuccess');
    }

    // Line Chart Pendapatan Bulanan
    const ctx = document.getElementById('dashboardChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($chartData),
                    tension: 0.45,
                    fill: true,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

});
</script>
@endpush

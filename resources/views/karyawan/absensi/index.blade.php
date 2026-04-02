@extends('layouts.master')

@section('title', 'Absensi Pegawai')

@section('content')

    <div class="container-fluid">

        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 text-gray-800">
                <i class="fas fa-user-clock"></i> Absensi Pegawai
            </h1>
        </div>

        <!-- Jam Real Time -->
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-body text-center">

                <h5 class="text-gray-600 mb-2">
                    <i class="fas fa-clock"></i> Jam Sekarang
                </h5>

                <h1 id="clock" class="font-weight-bold text-primary" style="font-size:50px"></h1>
                <p id="date" class="text-gray-500"></p>

            </div>
        </div>


        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger shadow-sm">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif


        <!-- Tombol Absensi -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-fingerprint"></i> Absensi Hari Ini
                </h6>
            </div>

            <div class="card-body text-center">

                <form action="{{ route('karyawan.absen.masuk') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-success btn-lg shadow mr-3">
                        <i class="fas fa-sign-in-alt"></i> Absen Masuk
                    </button>
                </form>

                <form action="{{ route('karyawan.absen.keluar') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger btn-lg shadow">
                        <i class="fas fa-sign-out-alt"></i> Absen Keluar
                    </button>
                </form>

            </div>

        </div>


        <!-- Riwayat Absensi -->
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history"></i> Riwayat Absensi
                </h6>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered">

                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($absensis as $absen)
                                <tr>

                                    <td>
                                        <strong>
                                            {{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}
                                        </strong>
                                    </td>

                                    <td>
                                        <span class="badge badge-success p-2">
                                            {{ $absen->jam_masuk ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-danger p-2">
                                            {{ $absen->jam_keluar ?? '-' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-info p-2">
                                            {{ ucfirst($absen->status) }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Belum ada data absensi
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <script>
        function updateClock() {

            const now = new Date();

            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const time = hours + ":" + minutes + ":" + seconds;

            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            const date = now.toLocaleDateString('id-ID', options);

            document.getElementById("clock").innerHTML = time;
            document.getElementById("date").innerHTML = date;
        }

        setInterval(updateClock, 1000);

        updateClock();
    </script>

@endsection

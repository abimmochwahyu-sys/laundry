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

    <!-- QR Code Absensi -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-qrcode"></i> Scan QR Absensi
            </h6>
        </div>

        <div class="card-body text-center">

            <h4 class="mb-3">
                Scan QR untuk Absensi
            </h4>

            {!! QrCode::size(250)->generate(route('admin.absen.scan', Auth::user()->id)) !!}

            <p class="text-muted mt-3">
                QR ini digunakan untuk <b>absen masuk dan keluar</b>
            </p>

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

// Suara ketika berhasil absen
@if(session('success'))
    // Buat audio context untuk suara yang jelas dan keras
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    
    function playSuccessSound() {
        // Buat suara beep yang sederhana dan jelas
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        // Suara beep dengan frekuensi konstan
        oscillator.frequency.setValueAtTime(800, audioContext.currentTime); // Frekuensi beep standar
        
        oscillator.type = 'square'; // Square wave untuk beep yang tajam
        
        // Volume cukup keras
        gainNode.gain.setValueAtTime(0.7, audioContext.currentTime); // Volume 70%
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3); // Fade out cepat
        
        // Mainkan beep singkat selama 0.3 detik
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.3);
    }
    
    // Mainkan suara setelah halaman load
    window.addEventListener('load', function() {
        setTimeout(playSuccessSound, 500); // Delay 500ms agar tidak langsung
    });
@endif

</script>

@endsection
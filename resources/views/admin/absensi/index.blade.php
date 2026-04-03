@extends('layouts.master')

@section('title', 'Data Absensi Karyawan')

@section('content')

    <style>
        /* Update CSS Anda */
        .scanner-wrapper {
            position: relative;
            width: 400px;
            max-width: 100%;
            margin: auto;
            min-height: 300px;
            /* Tambahkan ini agar card tidak gepeng saat loading */
            background: #f8f9fc;
            border-radius: 10px;
            border: 2px dashed #ccc;
        }

        #reader {
            width: 100% !important;
            border: none !important;
        }

        /* Sembunyikan overlay custom jika library sudah menyediakan qrbox */
        .scan-overlay {
            display: none;
        }
    </style>

    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">
            <i class="fas fa-user-check"></i> Data Absensi Karyawan
        </h1>

        {{-- ALERT --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- CARD SCANNER -->

        <div class="card shadow mb-4">

            <div class="card-header font-weight-bold">
                <i class="fas fa-camera"></i> Scan QR Karyawan
            </div>

            <div class="card-body text-center">

                <div class="scanner-wrapper">

                    <div id="reader"></div>

                    <div class="scan-overlay"></div>

                </div>

                <p class="text-muted mt-3">
                    Arahkan kamera ke QR Code karyawan
                </p>

            </div>

        </div>

        <!-- CARD RIWAYAT -->

        <div class="card shadow">

            <div class="card-header font-weight-bold">
                <i class="fas fa-history"></i> Riwayat Absensi Pegawai
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="bg-primary text-white">

                            <tr>
                                <th>Nama Karyawan</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($absensis as $absen)
                                <tr>

                                    <td>{{ $absen->user->name }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}
                                    </td>

                                    <td>
                                        <span class="badge badge-success">
                                            {{ $absen->jam_masuk }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge badge-danger">
                                            {{ $absen->jam_keluar ?? '-' }}
                                        </span>
                                    </td>

                                    <td>

                                        @if ($absen->status == 'telat')
                                            <span class="badge badge-warning">
                                                Telat
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                Hadir
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Belum ada data absensi
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">
                    {{ $absensis->links() }}
                </div>

            </div>

        </div>

    </div>

    @push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- FUNGSI UNTUK SUARA (TEXT TO SPEECH) LEBIH TEGAS ---
function speak(text) {
    if ('speechSynthesis' in window) {
        // Batalkan suara yang sedang berjalan agar tidak tumpang tindih
        window.speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        
        // Ambil semua daftar suara yang tersedia di browser
        const voices = window.speechSynthesis.getVoices();

        // Cari suara yang mendukung Bahasa Indonesia (id-ID)
        const idVoice = voices.find(voice => voice.lang === 'id-ID' || voice.lang.includes('id'));

        if (idVoice) {
            utterance.voice = idVoice; // Paksa pakai suara Indonesia agar angka dibaca benar
        }

        utterance.lang = 'id-ID';
        utterance.rate = 0.7// Sedikit diperlambat agar artikulasi angka lebih jelas (tegas)
        utterance.pitch = 3; // Nada sedikit dinaikkan agar terdengar lebih formal/berwibawa
        utterance.volume = 1.0; // Volume maksimal

        window.speechSynthesis.speak(utterance);
    }
}

// Karena getVoices() kadang asinkron (load telat), kita panggil ini agar browser siap
window.speechSynthesis.onvoiceschanged = function() {
    window.speechSynthesis.getVoices();
};

        // --- LOGIKA SWEETALERT & SUARA DARI SESSION ---
        @if (session('success'))
            let msgSuccess = "{{ session('success') }}";
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: msgSuccess,
                showConfirmButton: true
            });
            speak(msgSuccess); // Browser menyebutkan nama & status
        @endif

        @if (session('error'))
            let msgError = "{{ session('error') }}";
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: msgError,
                showConfirmButton: true
            });
            speak(msgError); // Browser menyebutkan alasan gagal
        @endif

        @if (session('warning'))
            let msgWarning = "{{ session('warning') }}";
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: msgWarning,
                showConfirmButton: true
            });
            speak(msgWarning);
        @endif

        // --- LOGIKA SCANNER QR ---
        const readerElement = document.getElementById('reader');
        if (readerElement) {
            const html5QrCode = new Html5Qrcode("reader");
            
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                window.location.href = decodedText;
                html5QrCode.stop();
            };

            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0 
            };

            html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                qrCodeSuccessCallback
            ).catch(err => {
                html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);
            });
        }
    });
</script>
@endpush
@endsection

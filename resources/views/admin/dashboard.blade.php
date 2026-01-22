@extends('layouts.master')
@section('title', 'Dashboard Admin')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            Selamat datang {{ Auth::user()->name }} 🚀
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Periksa apakah ada notifikasi login
        const loginSuccess = localStorage.getItem('loginSuccess');
        
        if (loginSuccess === 'true') {
            Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: 'Selamat datang kembali di dashboard SICLEAN',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
            
            // Hapus flag setelah menampilkan notifikasi
            localStorage.removeItem('loginSuccess');
        }
        
        // Periksa jika ada pesan sukses dari session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                toast: true,
                position: 'top-end'
            });
        @endif
    });
</script>
@endpush
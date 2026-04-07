@extends('layouts.master')

@section('title', 'Tambah Karyawan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Karyawan</h1>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.karyawan.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>

            <div class="form-group mb-3">
                <label>No Telepon</label>
                <input type="text" name="telepon" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label>Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label>Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" id="toggleConfirmPassword">
                            <i class="fas fa-eye" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPasswordField = document.getElementById('password_confirmation');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');
    
    if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        eyeIconConfirm.classList.remove('fa-eye');
        eyeIconConfirm.classList.add('fa-eye-slash');
    } else {
        confirmPasswordField.type = 'password';
        eyeIconConfirm.classList.remove('fa-eye-slash');
        eyeIconConfirm.classList.add('fa-eye');
    }
});
</script>
@endsection

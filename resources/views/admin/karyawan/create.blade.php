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
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>


                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection

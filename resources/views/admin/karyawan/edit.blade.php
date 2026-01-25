@extends('layouts.master')

@section('title','Edit Karyawan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Karyawan</h1>

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
        <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" 
                       value="{{ old('nama', $karyawan->nama) }}" required>
            </div>

            <div class="form-group mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label>No Telepon</label>
                <input type="text" name="telepon" class="form-control" 
                       value="{{ old('telepon', $karyawan->telepon) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </form>
    </div>
</div>
@endsection

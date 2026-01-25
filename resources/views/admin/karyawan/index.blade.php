@extends('layouts.master')

@section('title','Data Karyawan')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Karyawan</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary mb-3">
    + Tambah Karyawan
</a>

<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawans as $karyawan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $karyawan->user->name ?? 'N/A' }}</td>
            <td>{{ $karyawan->user->email }}</td>
            <td>{{ $karyawan->telepon }}</td>
            <td>
                <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Data karyawan belum ada
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

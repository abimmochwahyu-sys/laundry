@extends('layouts.master')
@section('title', 'Data Layanan')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Layanan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Layanan
        </a>
    </div>

    <div class="row">
        @forelse ($layanans as $layanan)
            <div class="col-md-4 mb-4">
                <div class="card shadow h-100 border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold text-primary">
                            {{ $layanan->jenis_layanan }}
                        </h5>
                        <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($layanan->harga, 0, ',', '.') }}/Kg</p>
                        <p class="mb-1"><strong>Estimasi:</strong> {{ $layanan->estimasi_waktu }} hari</p>
                        <p class="text-muted">{{ $layanan->deskripsi }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.layanan.destroy', $layanan->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada layanan yang tersedia.
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $layanans->links() }}
    </div>
@endsection
    
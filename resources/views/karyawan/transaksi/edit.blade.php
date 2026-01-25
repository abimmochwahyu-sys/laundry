@extends('layouts.master')
@section('title', 'Edit Layanan')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Layanan</h1>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Layanan</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('karyawan.layanan.update', $layanan->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_pelanggan" class="form-label font-weight-bold">
                                    <i class="fas fa-karyawan mr-1 text-primary"></i> Nama Pelanggan
                                </label>
                                <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" 
                                    id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $layanan->nama_pelanggan) }}" required>
                                @error('nama_pelanggan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="jenis_layanan" class="form-label font-weight-bold">
                                    <i class="fas fa-concierge-bell mr-1 text-primary"></i> Jenis Layanan
                                </label>
                                <select class="form-control @error('jenis_layanan') is-invalid @enderror" 
                                    id="jenis_layanan" name="jenis_layanan" required>
                                    <option value="" disabled>-- Pilih Jenis Layanan --</option>
                                    <option value="Cuci Basah" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'Cuci Basah' ? 'selected' : '' }}>Cuci Basah</option>
                                    <option value="Cuci Kering" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'Cuci Kering' ? 'selected' : '' }}>Cuci Kering</option>
                                    <option value="Setrika" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'Setrika' ? 'selected' : '' }}>Setrika</option>
                                    <option value="Cuci + Setrika" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'Cuci + Setrika' ? 'selected' : '' }}>Cuci + Setrika</option>
                                    <option value="Dry Cleaning" {{ old('jenis_layanan', $layanan->jenis_layanan) == 'Dry Cleaning' ? 'selected' : '' }}>Dry Cleaning</option>
                                </select>
                                @error('jenis_layanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga_per_kilo" class="form-label font-weight-bold">
                                    <i class="fas fa-money-bill-wave mr-1 text-primary"></i> Harga per Kilo (Rp)
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control @error('harga_per_kilo') is-invalid @enderror" 
                                        id="harga_per_kilo" name="harga_per_kilo" value="{{ old('harga_per_kilo', $layanan->harga_per_kilo) }}" min="0" required>
                                    @error('harga_per_kilo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="estimasi_waktu" class="form-label font-weight-bold">
                                    <i class="fas fa-clock mr-1 text-primary"></i> Estimasi Waktu (hari)
                                </label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('estimasi_waktu') is-invalid @enderror" 
                                        id="estimasi_waktu" name="estimasi_waktu" value="{{ old('estimasi_waktu', $layanan->estimasi_waktu) }}" min="1" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">hari</span>
                                    </div>
                                    @error('estimasi_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label font-weight-bold">
                                <i class="fas fa-info-circle mr-1 text-primary"></i> Deskripsi (Opsional)
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                            <small class="form-text text-muted">Tambahkan deskripsi atau catatan tambahan untuk layanan ini</small>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('karyawan.layanan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi</h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold">Petunjuk Pengisian:</h6>
                    <ul>
                        <li>Nama Pelanggan: Nama lengkap pelanggan</li>
                        <li>Jenis Layanan: Pilih jenis layanan yang tersedia</li>
                        <li>Harga per Kilo: Harga dalam Rupiah</li>
                        <li>Estimasi Waktu: Perkiraan waktu pengerjaan dalam hari</li>
                        <li>Deskripsi: Informasi tambahan tentang layanan (opsional)</li>
                    </ul>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold">Data Saat Ini:</h6>
                    <table class="table table-sm">
                        <tr>
                            <th>Nama Pelanggan</th>
                            <td>: {{ $layanan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Layanan</th>
                            <td>: {{ $layanan->jenis_layanan }}</td>
                        </tr>
                        <tr>
                            <th>Harga per Kilo</th>
                            <td>: Rp {{ number_format($layanan->harga_per_kilo, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Estimasi Waktu</th>
                            <td>: {{ $layanan->estimasi_waktu }} hari</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
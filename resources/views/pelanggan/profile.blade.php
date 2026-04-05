@extends('layouts.master')

@section('title', 'Profil Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-circle mr-2"></i> Profil Saya
                </h5>
            </div>

            <div class="card-body">

                {{-- NOTIF SUKSES --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                {{-- ERROR VALIDASI --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                @endif

                <form action="{{ route('pelanggan.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            {{-- NAMA --}}
                            <div class="form-group">
                                <label for="name" class="font-weight-bold">
                                    <i class="fas fa-id-card mr-1 text-primary"></i> Nama Lengkap
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', auth()->user()->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- EMAIL --}}
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">
                                    <i class="fas fa-envelope mr-1 text-primary"></i> Email
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', auth()->user()->email) }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="font-weight-bold mb-3">
                        <i class="fas fa-lock mr-2 text-warning"></i> Ubah Password (Opsional)
                    </h6>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- CURRENT PASSWORD --}}
                            <div class="form-group">
                                <label for="current_password" class="font-weight-bold">Password Saat Ini</label>
                                <input type="password"
                                       id="current_password"
                                       name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{-- PASSWORD BARU --}}
                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Password Baru</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Min. 8 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- CONFIRM PASSWORD --}}
                            <div class="form-group">
                                <label for="password_confirmation" class="font-weight-bold">Konfirmasi Password</label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

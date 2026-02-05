@extends('layouts.master')

@section('title', 'Profil Admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card shadow">
            <div class="card-header text-center">
                <h5 class="mb-0">Profil Admin</h5>
            </div>

            <div class="card-body">

                {{-- NOTIF SUKSES --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ERROR VALIDASI --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- FOTO PROFIL --}}
                    <div class="text-center mb-4">
                        <img
                            src="{{ Auth::user()->photo
                                ? asset('storage/profile/' . Auth::user()->photo)
                                : asset('sbadmin2/img/undraw_profile.svg') }}"
                            class="rounded-circle mb-2"
                            width="120"
                            height="120"
                            style="object-fit: cover;"
                        >

                        <input type="file"
                               name="photo"
                               class="form-control-file mt-2">
                    </div>

                    {{-- NAMA --}}
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               class="form-control"
                               required>
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               class="form-control"
                               required>
                    </div>

                    {{-- ALAMAT --}}
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat"
                                  class="form-control"
                                  rows="3">{{ old('alamat', Auth::user()->karyawan->alamat ?? '') }}</textarea>
                    </div>

                    {{-- TELEPON --}}
                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="text"
                               name="telepon"
                               value="{{ old('telepon', Auth::user()->karyawan->telepon ?? '') }}"
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        💾 Simpan Perubahan
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

@extends('layouts.master')
@section('title', 'Tambah Layanan')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Layanan</h1>

<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Layanan</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.layanan.store') }}">
            @include('admin.layanan._form', ['submit' => 'Simpan'])
        </form>
    </div>
</div>
@endsection

@extends('layouts.master')

@section('title','Pengaturan Jam Absensi')

@section('content')

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">
<i class="fas fa-clock"></i> Pengaturan Jam Absensi
</h1>

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<div class="card shadow">

<div class="card-body">

<form action="{{ route('admin.setting.absensi.update') }}" method="POST">

@csrf

<div class="form-group">
<label>Jam Masuk</label>
<input type="time" name="jam_masuk" class="form-control"
value="{{ $setting->jam_masuk ?? '' }}" required>
</div>

<div class="form-group">
<label>Batas Telat</label>
<input type="time" name="batas_telat" class="form-control"
value="{{ $setting->batas_telat ?? '' }}" required>
</div>

<div class="form-group">
<label>Jam Pulang</label>
<input type="time" name="jam_keluar" class="form-control"
value="{{ $setting->jam_keluar ?? '' }}" required>
</div>

<button class="btn btn-primary">
<i class="fas fa-save"></i> Simpan Pengaturan
</button>

</form>

</div>

</div>

</div>

@endsection

@extends('layouts.master')

@section('title','Data Absensi Karyawan')

@section('content')

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">
<i class="fas fa-user-check"></i> Data Absensi Karyawan
</h1>

<div class="card shadow">

<div class="card-header">
Riwayat Absensi Pegawai
</div>

<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead class="bg-primary text-white">

<tr>
<th>Nama Karyawan</th>
<th>Tanggal</th>
<th>Jam Masuk</th>
<th>Jam Keluar</th>
<th>Status</th>
</tr>

</thead>

<tbody>

@foreach($absensis as $absen)

<tr>

<td>{{ $absen->user->name }}</td>

<td>
{{ \Carbon\Carbon::parse($absen->tanggal)->format('d M Y') }}
</td>

<td>
<span class="badge badge-success">
{{ $absen->jam_masuk }}
</span>
</td>

<td>
<span class="badge badge-danger">
{{ $absen->jam_keluar ?? '-' }}
</span>
</td>

<td>

@if($absen->status == 'telat')

<span class="badge badge-warning">
Telat
</span>

@else

<span class="badge badge-success">
Hadir
</span>

@endif

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

</div>

@endsection
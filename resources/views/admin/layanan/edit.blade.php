@extends('layouts.master')
@section('title', 'Edit Layanan')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Edit Layanan</h1>

<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Layanan</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.layanan.update', $layanan->id) }}">
            @method('PUT')
            @include('admin.layanan._form', ['submit' => 'Update'])
        </form>
    </div>
</div>
@endsection

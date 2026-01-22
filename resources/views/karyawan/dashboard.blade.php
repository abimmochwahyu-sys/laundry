@extends('layouts.master')
@section('title', 'Dashboard Admin')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            Selamat datang {{ Auth::user()->name }} 🚀
        </div>
    </div>
@endsection
@extends('layouts.master')

@section('title', 'Akses Ditolak')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4><i class="fas fa-exclamation-triangle"></i> Akses Ditolak</h4>
                </div>
                <div class="card-body">
                    <h5>{{ $message ?? 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</h5>

                    @if(isset($required_role))
                        <p><strong>Role yang diperlukan:</strong> {{ ucfirst($required_role) }}</p>
                    @endif

                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.master')
@section('title', 'Detail Diskon')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detail Diskon</h1>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Diskon</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Kode Diskon:</th>
                            <td>{{ $diskon->kode_diskon }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan:</th>
                            <td>{{ $diskon->keterangan }}</td>
                        </tr>
                        <tr>
                            <th>Tipe Diskon:</th>
                            <td>
                                @if($diskon->tipe_diskon === 'persen')
                                    Persen (%)
                                @else
                                    Nominal (Rp)
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Diskon:</th>
                            <td>
                                @if($diskon->tipe_diskon === 'persen')
                                    {{ $diskon->nilai }}%
                                @else
                                    Rp {{ number_format($diskon->nilai, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Minimum Belanja:</th>
                            <td>Rp {{ number_format($diskon->minimum_belanja, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Berlaku Sampai:</th>
                            <td>{{ $diskon->berlaku_sampai->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($diskon->is_active && $diskon->berlaku_sampai >= now())
                                    <span class="badge badge-success">Aktif</span>
                                @elseif(!$diskon->is_active)
                                    <span class="badge badge-secondary">Nonaktif</span>
                                @else
                                    <span class="badge badge-warning">Kadaluarsa</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat:</th>
                            <td>{{ $diskon->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('karyawan.diskon.edit', $diskon) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('karyawan.diskon.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.master')
@section('title', 'Data Diskon')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0 text-gray-800">Data Diskon</h1>
        <a href="{{ route('admin.diskon.create') }}" class="btn btn-primary">
            + Tambah Diskon
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kode Diskon</th>
                            <th>Keterangan</th>
                            <th>Tipe</th>
                            <th>Nilai</th>
                            <th>Min. Belanja</th>
                            <th>Berlaku Sampai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($diskons as $diskon)
                            <tr>
                                <td class="text-center">{{ $diskons->firstItem() + $loop->index }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $diskon->kode_diskon }}</span>
                                </td>
                                <td>{{ $diskon->keterangan }}</td>
                                <td class="text-center">
                                    @if($diskon->tipe_diskon === 'persen')
                                        <span class="badge badge-info">Persen</span>
                                    @else
                                        <span class="badge badge-success">Nominal</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($diskon->tipe_diskon === 'persen')
                                        {{ $diskon->nilai }}%
                                    @else
                                        Rp {{ number_format($diskon->nilai, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    Rp {{ number_format($diskon->minimum_belanja, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    {{ $diskon->berlaku_sampai->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    @if($diskon->is_active && $diskon->berlaku_sampai >= now())
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif(!$diskon->is_active)
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @else
                                        <span class="badge badge-warning">Kadaluarsa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.diskon.edit', $diskon) }}"
                                           class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.diskon.toggle-status', $diskon) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('POST')
                                            @if($diskon->is_active)
                                                <button type="submit" class="btn btn-secondary btn-sm"
                                                        onclick="return confirm('Nonaktifkan diskon ini?')">
                                                    Nonaktif
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm"
                                                        onclick="return confirm('Aktifkan diskon ini?')">
                                                    Aktif
                                                </button>
                                            @endif
                                        </form>
                                        <form action="{{ route('admin.diskon.destroy', $diskon) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Hapus diskon ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-percent fa-2x mb-2"></i>
                                        <p>Belum ada data diskon</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $diskons->links() }}
            </div>
        </div>
    </div>
@endsection
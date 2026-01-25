@extends('layouts.master')

@section('title', 'Tambah Transaksi')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tambah Transaksi Laundry</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('karyawan.transaksi.store') }}" method="POST">
    @csrf

    {{-- Layanan --}}
    <div class="form-group">
        <label>Jenis Layanan</label>
        <select name="layanan_id" class="form-control" required>
            <option value="">-- Pilih Layanan --</option>
            @foreach($layanans as $layanan)
                <option value="{{ $layanan->id }}"
                        data-harga="{{ $layanan->harga_per_kg }}">
                    {{ $layanan->nama_layanan }} - Rp {{ number_format($layanan->harga_per_kg) }}/Kg
                </option>
            @endforeach
        </select>
    </div>

    {{-- Berat --}}
    <div class="form-group">
        <label>Berat (Kg)</label>
        <input type="number" name="berat" class="form-control" step="0.1" min="1" required>
    </div>

    {{-- Metode Pembayaran --}}
    <div class="form-group">
        <label>Metode Pembayaran</label>
        <select name="metode_pembayaran" class="form-control" required>
            <option value="">-- Pilih Metode --</option>
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="qris">QRIS</option>
        </select>
    </div>

    {{-- Tanggal --}}
    <div class="form-group">
        <label>Tanggal Transaksi</label>
        <input type="date" name="tanggal_transaksi" class="form-control"
               value="{{ date('Y-m-d') }}" required>
    </div>

    {{-- Total --}}
    <div class="form-group">
        <label>Total Harga</label>
        <input type="text" id="total" class="form-control" readonly>
    </div>

    <button class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan Transaksi
    </button>
</form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const layanan = document.querySelector('select[name="layanan_id"]');
    const berat = document.querySelector('input[name="berat_kg"]');
    const total = document.getElementById('total');

    function hitungTotal() {
        const harga = layanan.selectedOptions[0]?.dataset.harga || 0;
        const kg = berat.value || 0;
        total.value = 'Rp ' + (harga * kg).toLocaleString('id-ID');
    }

    layanan.addEventListener('change', hitungTotal);
    berat.addEventListener('input', hitungTotal);
});
</script>
@endpush

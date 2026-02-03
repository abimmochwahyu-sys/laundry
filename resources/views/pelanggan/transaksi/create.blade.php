@extends('layouts.master')
@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">
            <i class="fas fa-receipt text-primary mr-2"></i>
            Buat Transaksi Baru
        </h1>
        <a href="{{ route('pelanggan.transaksi.index') }}"
           class="btn btn-sm btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('pelanggan.transaksi.store') }}">
        @csrf

        <div class="row">

            <!-- Form Input -->
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-edit mr-1"></i> Form Transaksi
                        </h6>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-concierge-bell text-primary mr-1"></i>
                                Jenis Layanan
                            </label>
                            <select class="form-control" id="layanan_id" name="layanan_id" required>
                                <option value="" disabled selected>-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id }}"
                                        data-harga="{{ $layanan->harga }}">
                                        {{ $layanan->jenis_layanan }} —
                                        Rp {{ number_format($layanan->harga,0,',','.') }}/kg
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-weight-hanging text-primary mr-1"></i>
                                Berat Laundry (Kg)
                            </label>
                            <input type="number"
                                   class="form-control"
                                   id="berat"
                                   name="berat"
                                   min="0.1"
                                   step="0.1"
                                   placeholder="Contoh: 5.5"
                                   required>
                            <small class="text-muted">
                                Minimal 0.1 Kg
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-wallet text-primary mr-1"></i>
                                Metode Pembayaran
                            </label>
                            <select class="form-control" name="metode_pembayaran" required>
                                <option value="" disabled selected>-- Pilih Metode --</option>
                                <option value="cash">Cash</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Ringkasan & Diskon -->
            <div class="col-lg-5">
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">

                        <h6 class="font-weight-bold text-info mb-3">
                            <i class="fas fa-tags mr-1"></i>
                            Promo & Ringkasan
                        </h6>

                        <div class="alert alert-info small">
                            🎉 Dapatkan <b>diskon 3%</b> untuk transaksi dengan berat
                            lebih dari <b>4 Kg</b>
                        </div>

                        <!-- Kalkulasi -->
                        <div id="calculation-card" style="display:none;">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-right font-weight-bold" id="subtotal">Rp 0</td>
                                </tr>
                                <tr id="diskon-row" style="display:none;">
                                    <td class="text-success">Diskon (3%)</td>
                                    <td class="text-right text-success font-weight-bold" id="diskon">Rp 0</td>
                                </tr>
                                <tr class="border-top">
                                    <th>Total Bayar</th>
                                    <th class="text-right text-primary" id="total">Rp 0</th>
                                </tr>
                            </table>
                        </div>

                        <button class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-save mr-1"></i>
                            Buat Transaksi
                        </button>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const layanan = document.getElementById('layanan_id');
    const berat = document.getElementById('berat');

    const card = document.getElementById('calculation-card');
    const subtotalEl = document.getElementById('subtotal');
    const diskonRow = document.getElementById('diskon-row');
    const diskonEl = document.getElementById('diskon');
    const totalEl = document.getElementById('total');

    function rupiah(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function hitung() {
        if (!layanan.value || !berat.value) {
            card.style.display = 'none';
            return;
        }

        const harga = parseInt(
            layanan.options[layanan.selectedIndex].dataset.harga
        );
        const b = parseFloat(berat.value);

        const subtotal = harga * b;
        let diskon = 0;

        if (b > 4) {
            diskon = subtotal * 0.03;
            diskonRow.style.display = '';
        } else {
            diskonRow.style.display = 'none';
        }

        card.style.display = 'block';
        subtotalEl.textContent = rupiah(subtotal);
        diskonEl.textContent = '- ' + rupiah(diskon);
        totalEl.textContent = rupiah(subtotal - diskon);
    }

    layanan.addEventListener('change', hitung);
    berat.addEventListener('input', hitung);
});
</script>
@endpush

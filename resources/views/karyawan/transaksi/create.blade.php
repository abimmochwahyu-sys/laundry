@extends('layouts.master')
@section('title', 'Buat Transaksi Baru')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 text-gray-800">
            <i class="fas fa-plus-circle text-primary mr-2"></i>Buat Transaksi Baru
        </h1>
        <a href="{{ route('karyawan.transaksi.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i>Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('karyawan.transaksi.store') }}">
        @csrf

        <div class="row">

            <!-- Form Input -->
            <div class="col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-edit mr-2"></i>Data Transaksi
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-concierge-bell mr-1 text-primary"></i> Jenis Layanan
                            </label>
                            <select class="form-control" id="layanan_id" name="layanan_id" required>
                                <option value="" disabled selected>-- Pilih Layanan --</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
                                        {{ $layanan->jenis_layanan }} — Rp {{ number_format($layanan->harga,0,',','.') }}/kg
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-weight-hanging mr-1 text-primary"></i> Berat Laundry (Kg)
                            </label>
                            <input type="number" step="0.1" min="0.1" id="berat" name="berat" class="form-control" placeholder="Contoh: 5.5" required>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Minimal 0.1 Kg
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-wallet mr-1 text-primary"></i> Metode Pembayaran
                            </label>
                            <select class="form-control" name="metode_pembayaran" required>
                                <option value="" disabled selected>-- Pilih Metode --</option>
                                <option value="cash">Cash</option>
                                <option value="e-wallet">E-Wallet</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">
                                <i class="fas fa-percent mr-1 text-success"></i> Diskon (Opsional)
                            </label>
                            <select class="form-control" id="diskon_id" name="diskon_id">
                                <option value="">-- Tidak ada diskon --</option>
                                @foreach($diskons as $diskon)
                                    <option value="{{ $diskon->id }}"
                                            data-tipe="{{ $diskon->tipe_diskon }}"
                                            data-nilai="{{ $diskon->nilai }}"
                                            data-minimum="{{ $diskon->minimum_belanja }}">
                                        {{ $diskon->kode_diskon }} - {{ $diskon->keterangan }}
                                        @if($diskon->tipe_diskon == 'persen')
                                            ({{ $diskon->nilai }}%)
                                        @else
                                            (Rp {{ number_format($diskon->nilai, 0, ',', '.') }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Pilih diskon yang tersedia (jika memenuhi syarat minimum belanja)
                            </small>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="col-lg-5">
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-info mb-3">
                            <i class="fas fa-tags mr-1"></i>Promo & Ringkasan
                        </h6>

                        <div class="alert alert-info small">
                            💡 <b>Diskon Manual:</b> Pilih diskon yang tersedia untuk mendapatkan potongan harga
                        </div>

                        <div id="calculation-card" style="display:none;">
                            <table class="table table-sm table-borderless mb-2">
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="text-right font-weight-bold" id="subtotal">Rp 0</td>
                                </tr>
                                <tr id="diskon-row" style="display:none;">
                                    <td class="text-success" id="diskon-label">Diskon</td>
                                    <td class="text-right text-success font-weight-bold" id="diskon">Rp 0</td>
                                </tr>
                                <tr class="border-top">
                                    <th>Total Bayar</th>
                                    <th class="text-right text-primary" id="total">Rp 0</th>
                                </tr>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            <i class="fas fa-save mr-1"></i>Buat Transaksi
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
    const diskonSelect = document.getElementById('diskon_id');

    const subtotalEl = document.getElementById('subtotal');
    const diskonEl = document.getElementById('diskon');
    const diskonLabel = document.getElementById('diskon-label');
    const totalEl = document.getElementById('total');
    const diskonRow = document.getElementById('diskon-row');
    const card = document.getElementById('calculation-card');

    function rupiah(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function hitung() {
        if (!layanan.value || !berat.value) return;

        card.style.display = 'block';

        const harga = parseInt(layanan.options[layanan.selectedIndex].dataset.harga);
        const b = parseFloat(berat.value);
        let subtotal = harga * b;
        let diskon = 0;
        let diskonText = '';

        // Hitung diskon manual jika dipilih
        if (diskonSelect.value) {
            const selectedOption = diskonSelect.options[diskonSelect.selectedIndex];
            const tipe = selectedOption.dataset.tipe;
            const nilai = parseFloat(selectedOption.dataset.nilai);
            const minimum = parseFloat(selectedOption.dataset.minimum);

            if (subtotal >= minimum) {
                if (tipe === 'persen') {
                    diskon = subtotal * (nilai / 100);
                    diskonText = `Diskon (${nilai}%)`;
                } else {
                    diskon = nilai;
                    diskonText = 'Diskon (Rp)';
                }
            }
        }

        subtotalEl.textContent = rupiah(subtotal);

        if (diskon > 0) {
            diskonRow.style.display = '';
            diskonLabel.textContent = diskonText;
            diskonEl.textContent = '- ' + rupiah(diskon);
        } else {
            diskonRow.style.display = 'none';
        }

        totalEl.textContent = rupiah(subtotal - diskon);
    }

    layanan.addEventListener('change', hitung);
    berat.addEventListener('input', hitung);
    diskonSelect.addEventListener('change', hitung);
});
</script>
@endpush

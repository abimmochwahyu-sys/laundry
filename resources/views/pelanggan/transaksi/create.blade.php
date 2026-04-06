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
            <a href="{{ route('pelanggan.transaksi.index') }}" class="btn btn-sm btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('pelanggan.transaksi.store') }}" method="POST">
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
                                    @foreach ($layanans as $layanan)
                                        <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}">
                                            {{ $layanan->jenis_layanan }} —
                                            Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-weight-hanging text-primary mr-1"></i>
                                    Berat Laundry (Kg)
                                </label>
                                <input type="number" class="form-control" id="berat" name="berat" min="0.1"
                                    step="0.1" placeholder="Contoh: 5.5" required>
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

                                    <option value="cash">
                                        💵 Cash
                                    </option>

                                    <option value="midtrans">
                                        💳 Midtrans (QRIS / E-Wallet / Transfer Bank)
                                    </option>
                                </select>

                                {{-- <small class="text-muted">
                                    Pembayaran non-cash akan diproses melalui sistem Midtrans
                                </small> --}}
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-percent text-success mr-1"></i> Kode Diskon (Opsional)
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="kode_diskon" name="kode_diskon" 
                                           placeholder="Masukkan kode diskon (misal: DISKON10)">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="btn-validasi-diskon">
                                            <i class="fas fa-check mr-1"></i>Validasi
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted" id="diskon-error" style="display: none; color: red;"></small>
                                <small class="text-muted" id="diskon-info" style="display: none; color: green;"></small>
                                <input type="hidden" name="diskon_id" id="diskon_id" value="">
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

                            <div class="alert alert-success small" id="diskon-promo" style="display: none;">
                                <span id="diskon-promo-text"></span>
                            </div>

                            <!-- Kalkulasi -->
                            <div id="calculation-card" style="display:none;">
                                <table class="table table-sm table-borderless">
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
            const kodeDiskon = document.getElementById('kode_diskon');
            const btnValidasiDiskon = document.getElementById('btn-validasi-diskon');
            const diskonIdInput = document.getElementById('diskon_id');
            const diskonErrorEl = document.getElementById('diskon-error');
            const diskonInfoEl = document.getElementById('diskon-info');
            const diskonPromoEl = document.getElementById('diskon-promo');
            const diskonPromoText = document.getElementById('diskon-promo-text');

            const card = document.getElementById('calculation-card');
            const subtotalEl = document.getElementById('subtotal');
            const diskonRow = document.getElementById('diskon-row');
            const diskonLabel = document.getElementById('diskon-label');
            const diskonEl = document.getElementById('diskon');
            const totalEl = document.getElementById('total');

            let selectedDiskon = null; // Store selected discount info

            function rupiah(n) {
                return 'Rp ' + n.toLocaleString('id-ID');
            }

            // Validasi kode diskon via AJAX
            btnValidasiDiskon.addEventListener('click', async () => {
                const code = kodeDiskon.value.trim();
                
                if (!code) {
                    diskonErrorEl.textContent = 'Masukkan kode diskon terlebih dahulu';
                    diskonErrorEl.style.display = 'block';
                    diskonInfoEl.style.display = 'none';
                    selectedDiskon = null;
                    diskonIdInput.value = '';
                    hitung();
                    return;
                }

                try {
                    const response = await fetch('{{ route("pelanggan.diskon.validate") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ kode_diskon: code })
                    });

                    const data = await response.json();

                    if (data.success) {
                        selectedDiskon = data.diskon;
                        diskonIdInput.value = data.diskon.id;
                        diskonErrorEl.style.display = 'none';
                        diskonInfoEl.textContent = `✓ Diskon valid: ${data.diskon.keterangan}`;
                        diskonInfoEl.style.display = 'block';
                        hitung();
                    } else {
                        diskonErrorEl.textContent = data.message || 'Kode diskon tidak valid atau sudah kadaluarsa';
                        diskonErrorEl.style.display = 'block';
                        diskonInfoEl.style.display = 'none';
                        selectedDiskon = null;
                        diskonIdInput.value = '';
                        hitung();
                    }
                } catch (error) {
                    diskonErrorEl.textContent = 'Terjadi kesalahan saat validasi diskon';
                    diskonErrorEl.style.display = 'block';
                    diskonInfoEl.style.display = 'none';
                    console.error('Error:', error);
                }
            });

            // Clear discount when code is modified
            kodeDiskon.addEventListener('input', () => {
                diskonErrorEl.style.display = 'none';
                diskonInfoEl.style.display = 'none';
            });

            function hitung() {
                if (!layanan.value || !berat.value) {
                    card.style.display = 'none';
                    diskonPromoEl.style.display = 'none';
                    return;
                }

                const harga = parseInt(
                    layanan.options[layanan.selectedIndex].dataset.harga
                );
                const b = parseFloat(berat.value);

                const subtotal = harga * b;
                let diskon = 0;
                let diskonDescription = '';

                // Priority: 1. Discount code, 2. Default 3% for weight > 4kg
                if (selectedDiskon) {
                    // Check minimum purchase
                    if (subtotal >= selectedDiskon.minimum_belanja) {
                        if (selectedDiskon.tipe_diskon === 'persen') {
                            diskon = (subtotal * selectedDiskon.nilai) / 100;
                            diskonDescription = `Diskon ${selectedDiskon.nilai}% (Kode: ${selectedDiskon.kode_diskon})`;
                        } else {
                            diskon = Math.min(selectedDiskon.nilai, subtotal);
                            diskonDescription = `Diskon Rp ${selectedDiskon.nilai.toLocaleString('id-ID')} (Kode: ${selectedDiskon.kode_diskon})`;
                        }
                        diskonPromoEl.style.display = 'none';
                    } else {
                        // Minimum tidak terpenuhi, gunakan diskon otomatis
                        diskonErrorEl.textContent = `Minimum belanja Rp ${selectedDiskon.minimum_belanja.toLocaleString('id-ID')} tidak terpenuhi`;
                        selectedDiskon = null;
                        diskonIdInput.value = '';
                        diskonErrorEl.style.display = 'block';
                        diskonPromoEl.style.display = 'none';
                    }
                }

                card.style.display = 'block';
                subtotalEl.textContent = rupiah(subtotal);
                
                if (diskon > 0) {
                    diskonRow.style.display = '';
                    diskonLabel.textContent = diskonDescription;
                    diskonEl.textContent = '- ' + rupiah(diskon);
                } else {
                    diskonRow.style.display = 'none';
                }
                
                totalEl.textContent = rupiah(subtotal - diskon);
            }

            layanan.addEventListener('change', hitung);
            berat.addEventListener('input', hitung);
        });
    </script>
@endpush

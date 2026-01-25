@extends('layouts.master')
@section('title', 'Buat Transaksi Baru')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Transaksi Baru</h1>
        <a href="{{ route('karyawan.transaksi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Transaksi</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('karyawan.transaksi.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="layanan_id" class="form-label font-weight-bold">
                            <i class="fas fa-concierge-bell mr-1 text-primary"></i> Jenis Layanan
                        </label>
                        <select class="form-control @error('layanan_id') is-invalid @enderror" 
                            id="layanan_id" name="layanan_id" required>
                            <option value="" disabled selected>-- Pilih Jenis Layanan --</option>
                            @foreach($layanans as $layanan)
                                <option value="{{ $layanan->id }}" data-harga="{{ $layanan->harga }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                    {{ $layanan->jenis_layanan }} - Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg
                                </option>
                            @endforeach
                        </select>
                        @error('layanan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="berat" class="form-label font-weight-bold">
                            <i class="fas fa-weight mr-1 text-primary"></i> Berat (Kg)
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('berat') is-invalid @enderror" 
                                id="berat" name="berat" value="{{ old('berat') }}" min="0.1" step="0.1" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Kg</span>
                            </div>
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Minimal 0.1 kg</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="metode_pembayaran" class="form-label font-weight-bold">
                            <i class="fas fa-money-bill-wave mr-1 text-primary"></i> Metode Pembayaran
                        </label>
                        <select class="form-control @error('metode_pembayaran') is-invalid @enderror" 
                            id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                            <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="e-wallet" {{ old('metode_pembayaran') == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('metode_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Informasi Diskon</h6>
                                <p class="card-text">Dapatkan diskon 10% untuk transaksi dengan berat lebih dari 4 kg</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Real-time Calculation Table -->
                <div class="card mb-4" id="calculation-card" style="display: none;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-calculator mr-2"></i>Perhitungan Biaya</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Detail</th>
                                        <th class="text-right">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Jenis Layanan</td>
                                        <td id="jenis-layanan-detail">-</td>
                                        <td class="text-right" id="jenis-layanan-jumlah">-</td>
                                    </tr>
                                    <tr>
                                        <td>Berat</td>
                                        <td id="berat-detail">-</td>
                                        <td class="text-right" id="berat-jumlah">-</td>
                                    </tr>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td colspan="2" class="text-right" id="subtotal-jumlah">Rp 0</td>
                                    </tr>
                                    <tr id="diskon-row" style="display: none;">
                                        <td>Diskon (10%)</td>
                                        <td colspan="2" class="text-right text-success" id="diskon-jumlah">Rp 0</td>
                                    </tr>
                                    <tr class="bg-primary text-white">
                                        <td><strong>Total Bayar</strong></td>
                                        <td colspan="2" class="text-right"><strong id="total-bayar-jumlah">Rp 0</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Buat Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const layananSelect = document.getElementById('layanan_id');
        const beratInput = document.getElementById('berat');
        const calculationCard = document.getElementById('calculation-card');
        
        // Get elements for displaying calculation
        const jenisLayananDetail = document.getElementById('jenis-layanan-detail');
        const jenisLayananJumlah = document.getElementById('jenis-layanan-jumlah');
        const beratDetail = document.getElementById('berat-detail');
        const beratJumlah = document.getElementById('berat-jumlah');
        const subtotalJumlah = document.getElementById('subtotal-jumlah');
        const diskonRow = document.getElementById('diskon-row');
        const diskonJumlah = document.getElementById('diskon-jumlah');
        const totalBayarJumlah = document.getElementById('total-bayar-jumlah');
        
        function formatCurrency(amount) {
            return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
        }
        
        function updateTotal() {
            const layananId = layananSelect.value;
            const berat = parseFloat(beratInput.value) || 0;
            
            if (layananId && berat > 0) {
                // Show calculation card
                calculationCard.style.display = 'block';
                
                // Get selected option
                const selectedOption = layananSelect.options[layananSelect.selectedIndex];
                const hargaPerKg = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                const jenisLayanan = selectedOption.text.split(' - ')[0];
                
                // Calculate
                const subtotal = hargaPerKg * berat;
                let diskon = 0;
                let totalBayar = subtotal;
                
                // Check if eligible for discount
                if (berat > 4) {
                    diskon = subtotal * 0.1;
                    totalBayar = subtotal - diskon;
                    diskonRow.style.display = '';
                } else {
                    diskonRow.style.display = 'none';
                }
                
                // Update display
                jenisLayananDetail.textContent = jenisLayanan;
                jenisLayananJumlah.textContent = formatCurrency(hargaPerKg) + '/kg';
                beratDetail.textContent = berat.toFixed(1) + ' kg';
                beratJumlah.textContent = 'x ' + formatCurrency(hargaPerKg);
                subtotalJumlah.textContent = formatCurrency(subtotal);
                diskonJumlah.textContent = '- ' + formatCurrency(diskon);
                totalBayarJumlah.textContent = formatCurrency(totalBayar);
            } else {
                // Hide calculation card if no valid input
                calculationCard.style.display = 'none';
            }
        }
        
        layananSelect.addEventListener('change', updateTotal);
        beratInput.addEventListener('input', updateTotal);
    });
</script>
@endpush
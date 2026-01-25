@extends('layouts.user')
@section('title', 'Buat Transaksi Baru')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Transaksi Baru</h1>
        <a href="{{ route('user.transaksi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Transaksi</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.transaksi.store') }}">
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
                                <option value="{{ $layanan->id }}" {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                    {{ $layanan->jenis_layanan }} - Rp {{ number_format($layanan->harga_per_kilo, 0, ',', '.') }}/kg
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
                    <div class="col-md-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Informasi Diskon</h6>
                                <p class="card-text">Dapatkan diskon 10% untuk transaksi dengan total di atas Rp 100.000</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.transaksi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
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
        
        function updateTotal() {
            const layananId = layananSelect.value;
            const berat = parseFloat(beratInput.value) || 0;
            
            if (layananId && berat > 0) {
                // Get selected option
                const selectedOption = layananSelect.options[layananSelect.selectedIndex];
                const text = selectedOption.text;
                
                // Extract price from text
                const match = text.match(/Rp ([\d.]+)\/kg/);
                if (match) {
                    const pricePerKg = parseFloat(match[1].replace(/\./g, ''));
                    const total = pricePerKg * berat;
                    
                    // Check if eligible for discount
                    let diskon = 0;
                    let totalAkhir = total;
                    
                    if (total > 100000) {
                        diskon = total * 0.1;
                        totalAkhir = total - diskon;
                    }
                    
                    // Update info
                    let infoHtml = `
                        <div class="alert alert-info">
                            <strong>Total:</strong> Rp ${total.toLocaleString('id-ID')}<br>
                    `;
                    
                    if (diskon > 0) {
                        infoHtml += `
                            <strong>Diskon (10%):</strong> Rp ${diskon.toLocaleString('id-ID')}<br>
                            <strong>Total Akhir:</strong> Rp ${totalAkhir.toLocaleString('id-ID')}
                        `;
                    }
                    
                    infoHtml += `</div>`;
                    
                    document.getElementById('total-info').innerHTML = infoHtml;
                }
            } else {
                document.getElementById('total-info').innerHTML = '';
            }
        }
        
        layananSelect.addEventListener('change', updateTotal);
        beratInput.addEventListener('input', updateTotal);
    });
</script>
@endsection
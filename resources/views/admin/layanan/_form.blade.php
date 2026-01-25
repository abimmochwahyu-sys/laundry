@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="jenis_layanan" class="form-label font-weight-bold">
            <i class="fas fa-concierge-bell mr-1 text-primary"></i> Jenis Layanan
        </label>
        <input type="text" 
               class="form-control @error('jenis_layanan') is-invalid @enderror" 
               id="jenis_layanan" name="jenis_layanan"
               value="{{ old('jenis_layanan', $layanan->jenis_layanan ?? '') }}" required>
        @error('jenis_layanan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="harga" class="form-label font-weight-bold">
            <i class="fas fa-money-bill-wave mr-1 text-primary"></i> Harga per Kilo (Rp)
        </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
            </div>
            <input type="number" 
                   class="form-control @error('harga') is-invalid @enderror" 
                   id="harga" name="harga"
                   value="{{ old('harga', $layanan->harga ?? '') }}" min="0" required>
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="estimasi_waktu" class="form-label font-weight-bold">
            <i class="fas fa-clock mr-1 text-primary"></i> Estimasi Waktu (hari)
        </label>
        <div class="input-group">
            <input type="number" 
                   class="form-control @error('estimasi_waktu') is-invalid @enderror" 
                   id="estimasi_waktu" name="estimasi_waktu"
                   value="{{ old('estimasi_waktu', $layanan->estimasi_waktu ?? '') }}" min="1">
            <div class="input-group-append">
                <span class="input-group-text">hari</span>
            </div>
            @error('estimasi_waktu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="deskripsi" class="form-label font-weight-bold">
            <i class="fas fa-info-circle mr-1 text-primary"></i> Deskripsi (Opsional)
        </label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                  id="deskripsi" name="deskripsi" rows="2">{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save mr-1"></i> {{ $submit ?? 'Simpan' }}
    </button>
</div>

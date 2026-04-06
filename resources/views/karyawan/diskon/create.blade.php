@extends('layouts.master')
@section('title', 'Tambah Diskon - Karyawan')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Tambah Diskon</h1>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Diskon (Karyawan)</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('karyawan.diskon.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kode_diskon" class="form-label">Kode Diskon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_diskon') is-invalid @enderror"
                               id="kode_diskon" name="kode_diskon"
                               value="{{ old('kode_diskon') }}" required
                               placeholder="Contoh: DISKON10, SAVE50">
                        @error('kode_diskon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="keterangan" class="form-label">Keterangan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                               id="keterangan" name="keterangan"
                               value="{{ old('keterangan') }}" required
                               placeholder="Deskripsi diskon">
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipe_diskon" class="form-label">Tipe Diskon <span class="text-danger">*</span></label>
                        <select class="form-control @error('tipe_diskon') is-invalid @enderror"
                                id="tipe_diskon" name="tipe_diskon" required>
                            <option value="">Pilih Tipe Diskon</option>
                            <option value="persen" {{ old('tipe_diskon') === 'persen' ? 'selected' : '' }}>Persen (%)</option>
                            <option value="nominal" {{ old('tipe_diskon') === 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                        @error('tipe_diskon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nilai" class="form-label">Nilai Diskon <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('nilai') is-invalid @enderror"
                                   id="nilai" name="nilai" step="0.01" min="0"
                                   value="{{ old('nilai') }}" required
                                   placeholder="Masukkan nilai diskon">
                            <div class="input-group-append">
                                <span class="input-group-text" id="nilai-addon">%</span>
                            </div>
                        </div>
                        <small class="form-text text-muted">Untuk persen: maksimal 100%, untuk nominal: dalam Rupiah</small>
                        @error('nilai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="minimum_belanja" class="form-label">Minimum Belanja <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control @error('minimum_belanja') is-invalid @enderror"
                                   id="minimum_belanja" name="minimum_belanja" step="0.01" min="0"
                                   value="{{ old('minimum_belanja', 0) }}" required
                                   placeholder="0">
                        </div>
                        <small class="form-text text-muted">Minimum total belanja untuk menggunakan diskon</small>
                        @error('minimum_belanja')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="berlaku_sampai" class="form-label">Berlaku Sampai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('berlaku_sampai') is-invalid @enderror"
                               id="berlaku_sampai" name="berlaku_sampai"
                               value="{{ old('berlaku_sampai') }}" required>
                        @error('berlaku_sampai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   id="is_active" name="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktifkan diskon ini
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Diskon
                        </button>
                        <a href="{{ route('karyawan.diskon.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Update simbol berdasarkan tipe diskon
        document.getElementById('tipe_diskon').addEventListener('change', function() {
            const addon = document.getElementById('nilai-addon');
            const nilaiInput = document.getElementById('nilai');

            if (this.value === 'persen') {
                addon.textContent = '%';
                nilaiInput.max = 100;
                nilaiInput.placeholder = 'Masukkan persentase (0-100)';
            } else if (this.value === 'nominal') {
                addon.textContent = 'Rp';
                nilaiInput.removeAttribute('max');
                nilaiInput.placeholder = 'Masukkan nominal dalam Rupiah';
            }
        });

        // Set initial state
        document.getElementById('tipe_diskon').dispatchEvent(new Event('change'));
    </script>
@endsection

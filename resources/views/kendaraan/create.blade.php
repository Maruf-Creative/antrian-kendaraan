@extends('layouts.app')

@section('title', 'Tambah Kendaraan - Antrian Kendaraan')

@section('content')
<div class="mb-4">
    <a href="{{ route('kendaraan.index') }}" class="btn btn-sm btn-outline-primary mb-2" aria-label="Kembali ke daftar kendaraan">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.02em;">Tambah Kendaraan Baru</h3>
    <p class="text-muted small mb-0">Daftarkan data kendaraan baru ke dalam sistem antrian Anda.</p>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-7">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center text-white" style="width:38px; height:38px; border-radius:12px; background:linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); font-size:0.95rem;">
                    <i class="fas fa-car"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="color:#0f172a;">Formulir Kendaraan</h6>
                    <span class="text-muted" style="font-size:0.8rem;">Lengkapi informasi nomor polisi dan pemilik</span>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('kendaraan.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nomor_polisi" class="form-label">Nomor Polisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nomor_polisi') is-invalid @enderror" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi') }}" placeholder="Contoh: B 1234 ABC" required autofocus>
                        <div class="form-text text-muted">Pastikan nomor polisi sesuai format plat nomor kendaraan.</div>
                        @error('nomor_polisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select @error('jenis_kendaraan') is-invalid @enderror" id="jenis_kendaraan" name="jenis_kendaraan" required>
                            <option value="" disabled {{ old('jenis_kendaraan') ? '' : 'selected' }}>Pilih jenis kendaraan</option>
                            <option value="Motor" {{ old('jenis_kendaraan') == 'Motor' ? 'selected' : '' }}>Motor</option>
                            <option value="Mobil" {{ old('jenis_kendaraan') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                            <option value="Truk" {{ old('jenis_kendaraan') == 'Truk' ? 'selected' : '' }}>Truk</option>
                            <option value="Bus" {{ old('jenis_kendaraan') == 'Bus' ? 'selected' : '' }}>Bus</option>
                            <option value="Lainnya" {{ old('jenis_kendaraan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nama_pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pemilik') is-invalid @enderror" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik') }}" placeholder="Masukkan nama pemilik kendaraan" required>
                        @error('nama_pemilik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Data Kendaraan
                        </button>
                        <a href="{{ route('kendaraan.index') }}" class="btn btn-light border text-muted">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


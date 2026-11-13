@extends('layouts.app')

@section('title', 'Tambah Antrian - Antrian Kendaraan')

@section('content')
<div class="mb-4">
    <a href="{{ route('antrian.index') }}" class="btn btn-sm btn-outline-primary mb-2" aria-label="Kembali ke daftar antrian">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.02em;">Buat Tiket Antrian Baru</h3>
    <p class="text-muted small mb-0">Pilih kendaraan terdaftar untuk mendapatkan nomor antrian otomatis.</p>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-7">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center text-white" style="width:38px; height:38px; border-radius:12px; background:linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); font-size:0.95rem;">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="color:#0f172a;">Formulir Pembuatan Antrian</h6>
                    <span class="text-muted" style="font-size:0.8rem;">Nomor antrian akan di-generate otomatis per tanggal</span>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('antrian.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kendaraan_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select @error('kendaraan_id') is-invalid @enderror" id="kendaraan_id" name="kendaraan_id" required autofocus>
                            <option value="" disabled {{ old('kendaraan_id') ? '' : 'selected' }}>Pilih kendaraan yang akan mengantri</option>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                    {{ $kendaraan->nomor_polisi }} - {{ $kendaraan->nama_pemilik }} ({{ $kendaraan->jenis_kendaraan }})
                                </option>
                            @endforeach
                        </select>
                        @error('kendaraan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($kendaraans->isEmpty())
                            <div class="alert alert-warning py-2 mt-2 border-0" style="background:#fef3c7; color:#92400e; border-radius:10px; font-size:0.85rem;">
                                <i class="fas fa-exclamation-triangle me-1"></i> Belum ada data kendaraan terdaftar. Silakan <a href="{{ route('kendaraan.create') }}" class="fw-bold text-decoration-underline" style="color:#92400e;">tambah kendaraan</a> terlebih dahulu.
                            </div>
                        @endif
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal Pelayanan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="waktu" class="form-label">Waktu Kedatangan <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu', date('H:i')) }}" required>
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="p-3 mb-4 rounded-3 d-flex align-items-center gap-3" style="background: #f0f7ff; border: 1px solid #bfdbfe;">
                        <div class="d-flex align-items-center justify-content-center text-primary" style="width:36px; height:36px; border-radius:10px; background:#ffffff; box-shadow:0 2px 6px rgba(37,99,235,0.15); flex-shrink:0;">
                            <i class="fas fa-magic"></i>
                        </div>
                        <div class="small" style="color: #1e40af;">
                            <strong>Sistem Penomoran Otomatis:</strong> Nomor antrian (A001, A002, dst.) digenerate berurutan dan di-reset kembali dari A001 untuk setiap tanggal baru. Status awal adalah <strong>Menunggu</strong>.
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-primary" {{ $kendaraans->isEmpty() ? 'disabled' : '' }}>
                            <i class="fas fa-ticket-alt"></i> Terbitkan Nomor Antrian
                        </button>
                        <a href="{{ route('antrian.index') }}" class="btn btn-light border text-muted">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


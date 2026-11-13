@extends('layouts.app')

@section('title', 'Edit Antrian - Antrian Kendaraan')

@section('content')
<div class="mb-4">
    <a href="{{ route('antrian.index') }}" class="btn btn-sm btn-outline-primary mb-2" aria-label="Kembali ke daftar antrian">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <div class="d-flex flex-wrap align-items-center gap-3">
        <h3 class="fw-bold mb-0" style="color: #0f172a; letter-spacing: -0.02em;">Edit Data Antrian</h3>
        <span class="fw-bold px-3 py-1 rounded-3" style="background:#eff6ff; color:#1d4ed8; font-size:1.05rem; border:1px solid #bfdbfe;">
            Nomor: {{ $antrian->nomor_antrian }}
        </span>
    </div>
    <p class="text-muted small mb-0 mt-1">Perbarui jadwal, kendaraan, atau ubah status pelayanan antrian.</p>
</div>

<div class="row">
    <div class="col-lg-8 col-xl-7">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center text-white" style="width:38px; height:38px; border-radius:12px; background:linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); font-size:0.95rem;">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="color:#0f172a;">Ubah Data Antrian</h6>
                    <span class="text-muted" style="font-size:0.8rem;">Sesuaikan status antrian sesuai perkembangan di lapangan</span>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('antrian.update', $antrian) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="kendaraan_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select @error('kendaraan_id') is-invalid @enderror" id="kendaraan_id" name="kendaraan_id" required>
                            <option value="" disabled>Pilih kendaraan</option>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $antrian->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>
                                    {{ $kendaraan->nomor_polisi }} - {{ $kendaraan->nama_pemilik }} ({{ $kendaraan->jenis_kendaraan }})
                                </option>
                            @endforeach
                        </select>
                        @error('kendaraan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal Pelayanan <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $antrian->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="waktu" class="form-label">Waktu Kedatangan <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" value="{{ old('waktu', $antrian->waktu) }}" required>
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status Pelayanan <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            @foreach(['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'] as $status)
                                <option value="{{ $status }}" {{ old('status', $antrian->status) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui Antrian
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


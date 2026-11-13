@extends('layouts.app')

@section('title', 'Laporan - Antrian Kendaraan')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.02em;">Laporan & Cetak Dokumen</h3>
    <p class="text-muted small mb-0">Hasilkan dan cetak laporan resmi data kendaraan dan antrian dalam format PDF.</p>
</div>

<div class="row g-4">
    <!-- Laporan Data Kendaraan -->
    <div class="col-md-6 col-lg-5">
        <div class="card h-100 text-center p-4">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <!-- Squircle Icon matching the image -->
                <div class="mb-3 d-flex align-items-center justify-content-center text-white" style="width:78px; height:78px; border-radius:22px; background:linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); box-shadow: 0 10px 24px rgba(37, 99, 235, 0.3);">
                    <i class="fas fa-car fa-2x"></i>
                </div>
                <span class="badge mb-2" style="background:#eff6ff; color:#1d4ed8; font-weight:700; padding:0.35rem 0.8rem; border-radius:999px; border:1px solid #bfdbfe; font-size:0.75rem;">
                    FORMAT PDF (PORTRAIT)
                </span>
                <h5 class="fw-bold mb-2" style="color:#0f172a;">Laporan Data Kendaraan</h5>
                <p class="text-muted small mb-4" style="max-width: 320px;">
                    Mencakup rekapitulasi seluruh nomor polisi, jenis kendaraan, dan nama pemilik yang terdaftar pada akun Anda.
                </p>
                <a href="{{ route('laporan.kendaraan.pdf') }}" target="_blank" class="btn btn-primary w-100" style="max-width: 280px;">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Laporan Data Antrian -->
    <div class="col-md-6 col-lg-5">
        <div class="card h-100 text-center p-4">
            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                <!-- Squircle Icon matching the image -->
                <div class="mb-3 d-flex align-items-center justify-content-center text-white" style="width:78px; height:78px; border-radius:22px; background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); box-shadow: 0 10px 24px rgba(2, 132, 199, 0.3);">
                    <i class="fas fa-file-lines fa-2x"></i>
                </div>
                <span class="badge mb-2" style="background:#e0f2fe; color:#0369a1; font-weight:700; padding:0.35rem 0.8rem; border-radius:999px; border:1px solid #bae6fd; font-size:0.75rem;">
                    FORMAT PDF (LANDSCAPE)
                </span>
                <h5 class="fw-bold mb-2" style="color:#0f172a;">Laporan Data Antrian</h5>
                <p class="text-muted small mb-4" style="max-width: 320px;">
                    Mencakup riwayat nomor antrian, jadwal tanggal dan waktu pelayanan, nomor polisi, serta status antrian terkini.
                </p>
                <a href="{{ route('laporan.antrian.pdf') }}" target="_blank" class="btn btn-primary w-100" style="max-width: 280px; background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


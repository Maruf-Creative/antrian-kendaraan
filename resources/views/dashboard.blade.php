@extends('layouts.app')

@section('title', 'Dashboard - Antrian Kendaraan')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.02em;">Dashboard Antrian</h3>
        <p class="text-muted mb-0 small">Ringkasan status pengelolaan kendaraan dan antrian Anda secara real-time.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('antrian.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Buat Antrian Baru
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Total Kendaraan -->
    <div class="col-sm-6 col-xl">
        <a href="{{ route('kendaraan.index') }}" class="text-decoration-none">
            <div class="card h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center text-white" style="width:52px; height:52px; border-radius:15px; background:linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); box-shadow: 0 6px 14px rgba(37, 99, 235, 0.28); flex-shrink:0;">
                        <i class="fas fa-car fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Kendaraan</div>
                        <div class="fw-bold fs-4" style="color:#0f172a;">{{ $totalKendaraan }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Total Antrian -->
    <div class="col-sm-6 col-xl">
        <a href="{{ route('antrian.index') }}" class="text-decoration-none">
            <div class="card h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center text-white" style="width:52px; height:52px; border-radius:15px; background:linear-gradient(135deg, #818cf8 0%, #4f46e5 100%); box-shadow: 0 6px 14px rgba(79, 70, 229, 0.28); flex-shrink:0;">
                        <i class="fas fa-list-ol fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Antrian</div>
                        <div class="fw-bold fs-4" style="color:#0f172a;">{{ $totalAntrian }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Menunggu -->
    <div class="col-sm-6 col-xl">
        <a href="{{ route('antrian.index', ['status' => 'Menunggu']) }}" class="text-decoration-none" title="Filter antrian: Menunggu">
            <div class="card h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center text-white" style="width:52px; height:52px; border-radius:15px; background:linear-gradient(135deg, #fbbf24 0%, #d97706 100%); box-shadow: 0 6px 14px rgba(217, 119, 6, 0.28); flex-shrink:0;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Menunggu</div>
                        <div class="fw-bold fs-4" style="color:#0f172a;">{{ $menunggu }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Diproses -->
    <div class="col-sm-6 col-xl">
        <a href="{{ route('antrian.index', ['status' => 'Diproses']) }}" class="text-decoration-none" title="Filter antrian: Diproses">
            <div class="card h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center text-white" style="width:52px; height:52px; border-radius:15px; background:linear-gradient(135deg, #38bdf8 0%, #0284c7 100%); box-shadow: 0 6px 14px rgba(2, 132, 199, 0.28); flex-shrink:0;">
                        <i class="fas fa-cog fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Diproses</div>
                        <div class="fw-bold fs-4" style="color:#0f172a;">{{ $diproses }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Selesai -->
    <div class="col-sm-6 col-xl">
        <a href="{{ route('antrian.index', ['status' => 'Selesai']) }}" class="text-decoration-none" title="Filter antrian: Selesai">
            <div class="card h-100 hover-lift">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center text-white" style="width:52px; height:52px; border-radius:15px; background:linear-gradient(135deg, #34d399 0%, #059669 100%); box-shadow: 0 6px 14px rgba(5, 150, 105, 0.28); flex-shrink:0;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Selesai</div>
                        <div class="fw-bold fs-4" style="color:#0f172a;">{{ $selesai }}</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex align-items-center justify-content-center text-primary" style="width:34px; height:34px; border-radius:10px; background:#eff6ff;">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h6 class="fw-bold mb-0" style="color:#0f172a;">Antrian Terbaru</h6>
                <span class="text-muted" style="font-size:0.78rem;">5 data antrian terakhir yang terdaftar</span>
            </div>
        </div>
        <a href="{{ route('antrian.index') }}" class="btn btn-outline-primary btn-sm">
            Lihat Semua Antrian <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="padding-left:1.5rem;">Nomor Antrian</th>
                        <th>Nomor Polisi</th>
                        <th>Nama Pemilik</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="text-align:right; padding-right:1.5rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrianTerbaru as $antrian)
                        <tr>
                            <td style="padding-left:1.5rem;">
                                <span class="fw-bold px-2 py-1 rounded-2" style="background:#eff6ff; color:#1d4ed8; font-size:0.88rem;">
                                    {{ $antrian->nomor_antrian }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $antrian->kendaraan ? $antrian->kendaraan->nomor_polisi : '-' }}</span>
                                <span class="text-muted small d-block">{{ $antrian->kendaraan ? $antrian->kendaraan->jenis_kendaraan : '' }}</span>
                            </td>
                            <td>{{ $antrian->kendaraan ? $antrian->kendaraan->nama_pemilik : '-' }}</td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($antrian->tanggal)->format('d/m/Y') }}</div>
                                <span class="text-muted small">{{ date('H:i', strtotime($antrian->waktu)) }} WIB</span>
                            </td>
                            <td>
                                @if($antrian->status === 'Menunggu')
                                    <span class="badge-status badge-menunggu"><i class="fas fa-clock"></i> Menunggu</span>
                                @elseif($antrian->status === 'Diproses')
                                    <span class="badge-status badge-diproses"><i class="fas fa-cog"></i> Diproses</span>
                                @elseif($antrian->status === 'Selesai')
                                    <span class="badge-status badge-selesai"><i class="fas fa-check"></i> Selesai</span>
                                @elseif($antrian->status === 'Dibatalkan')
                                    <span class="badge-status badge-dibatalkan"><i class="fas fa-times"></i> Dibatalkan</span>
                                @endif
                            </td>
                            <td style="text-align:right; padding-right:1.5rem;">
                                <a href="{{ route('antrian.edit', $antrian) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit antrian {{ $antrian->nomor_antrian }}">
                                    <i class="fas fa-pen"></i> Ubah
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width:54px; height:54px; border-radius:16px; background:#eff6ff; color:#3b82f6;">
                                    <i class="fas fa-inbox fa-2x"></i>
                                </div>
                                <div class="fw-semibold">Belum ada antrian terdaftar</div>
                                <div class="small text-muted mt-1">Mulai dengan menambahkan data kendaraan dan membuat antrian pertama.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


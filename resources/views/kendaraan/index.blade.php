@extends('layouts.app')

@section('title', 'Data Kendaraan - Antrian Kendaraan')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.02em;">Data Kendaraan</h3>
        <p class="text-muted mb-0 small">Kelola seluruh armada kendaraan yang terhubung dengan akun Anda.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('laporan.kendaraan.pdf') }}" target="_blank" class="btn btn-outline-danger">
            <i class="fas fa-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Kendaraan
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('kendaraan.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border-color: #cbd5e1;">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="nomor_polisi" class="form-control border-start-0" placeholder="Cari nomor polisi..." value="{{ request('nomor_polisi') }}" style="border-radius: 0 12px 12px 0;">
            </div>
            <button type="submit" class="btn btn-sm btn-outline-primary">
                Cari
            </button>
            @if(request('nomor_polisi'))
                <a href="{{ route('kendaraan.index') }}" class="btn btn-sm btn-light border text-muted">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:70px; padding-left:1.5rem;">No</th>
                        <th>Nomor Polisi</th>
                        <th>Jenis Kendaraan</th>
                        <th>Nama Pemilik</th>
                        <th style="width:160px; text-align:right; padding-right:1.5rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraans as $index => $kendaraan)
                        <tr>
                            <td style="padding-left:1.5rem;" class="text-muted fw-semibold">{{ $kendaraans->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="d-flex align-items-center justify-content-center text-white" style="width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); font-size:0.85rem; flex-shrink:0;">
                                        <i class="fas fa-car"></i>
                                    </div>
                                    <span class="fw-bold" style="color:#0f172a; font-size:0.95rem;">{{ $kendaraan->nomor_polisi }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background:#eff6ff; color:#1d4ed8; font-weight:600; padding:0.4rem 0.75rem; border-radius:8px; border:1px solid #bfdbfe;">
                                    {{ $kendaraan->jenis_kendaraan }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $kendaraan->nama_pemilik }}</span>
                            </td>
                            <td style="text-align:right; padding-right:1.5rem;">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('kendaraan.edit', $kendaraan) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit kendaraan {{ $kendaraan->nomor_polisi }}" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('kendaraan.destroy', $kendaraan) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data kendaraan ini? Antrian terkait juga akan terhapus.')" aria-label="Hapus kendaraan {{ $kendaraan->nomor_polisi }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width:54px; height:54px; border-radius:16px; background:#eff6ff; color:#3b82f6;">
                                    <i class="fas fa-car fa-2x"></i>
                                </div>
                                <div class="fw-semibold">Belum ada data kendaraan</div>
                                <div class="small text-muted mt-1">Silakan tambahkan kendaraan terlebih dahulu untuk mulai membuat antrian.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($kendaraans->hasPages())
        <div class="card-footer bg-white border-0 pt-3 pb-3" style="border-bottom-left-radius:18px; border-bottom-right-radius:18px;">
            {{ $kendaraans->links() }}
        </div>
    @endif
</div>
@endsection


@extends('layouts.app')

@section('title', 'Data Antrian - Antrian Kendaraan')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a; letter-spacing: -0.02em;">Data Antrian Kendaraan</h3>
        <p class="text-muted mb-0 small">Pantau status nomor antrian, jadwal pelayanan, dan data kendaraan.</p>
    </div>
    <a href="{{ route('antrian.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Antrian Baru
    </a>
</div>

<!-- Quick Status Filter Pills -->
<div class="d-flex flex-wrap gap-2 mb-3">
    <a href="{{ route('antrian.index', array_filter(['search' => request('search'), 'tanggal' => request('tanggal')])) }}"
       class="btn btn-sm {{ !request('status') || request('status') == 'Semua' ? 'btn-primary' : 'btn-light border' }}"
       style="border-radius: 999px; padding: 0.4rem 1rem;">
        Semua Status <span class="badge ms-1 {{ !request('status') || request('status') == 'Semua' ? 'bg-white text-primary' : 'bg-secondary text-white' }}">{{ $counts['semua'] ?? 0 }}</span>
    </a>
    <a href="{{ route('antrian.index', array_filter(['status' => 'Menunggu', 'search' => request('search'), 'tanggal' => request('tanggal')])) }}"
       class="btn btn-sm {{ request('status') == 'Menunggu' ? 'btn-warning text-dark fw-bold' : 'btn-light border' }}"
       style="border-radius: 999px; padding: 0.4rem 1rem;">
        <i class="fas fa-clock text-warning"></i> Menunggu <span class="badge ms-1 bg-warning text-dark">{{ $counts['menunggu'] ?? 0 }}</span>
    </a>
    <a href="{{ route('antrian.index', array_filter(['status' => 'Diproses', 'search' => request('search'), 'tanggal' => request('tanggal')])) }}"
       class="btn btn-sm {{ request('status') == 'Diproses' ? 'btn-info text-dark fw-bold' : 'btn-light border' }}"
       style="border-radius: 999px; padding: 0.4rem 1rem;">
        <i class="fas fa-cog text-info"></i> Diproses <span class="badge ms-1 bg-info text-dark">{{ $counts['diproses'] ?? 0 }}</span>
    </a>
    <a href="{{ route('antrian.index', array_filter(['status' => 'Selesai', 'search' => request('search'), 'tanggal' => request('tanggal')])) }}"
       class="btn btn-sm {{ request('status') == 'Selesai' ? 'btn-success text-white fw-bold' : 'btn-light border' }}"
       style="border-radius: 999px; padding: 0.4rem 1rem;">
        <i class="fas fa-check-circle text-success"></i> Selesai <span class="badge ms-1 bg-success text-white">{{ $counts['selesai'] ?? 0 }}</span>
    </a>
    <a href="{{ route('antrian.index', array_filter(['status' => 'Dibatalkan', 'search' => request('search'), 'tanggal' => request('tanggal')])) }}"
       class="btn btn-sm {{ request('status') == 'Dibatalkan' ? 'btn-danger text-white fw-bold' : 'btn-light border' }}"
       style="border-radius: 999px; padding: 0.4rem 1rem;">
        <i class="fas fa-times-circle text-danger"></i> Dibatalkan <span class="badge ms-1 bg-danger text-white">{{ $counts['dibatalkan'] ?? 0 }}</span>
    </a>
</div>

<!-- Detailed Filter & Search Card -->
<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('antrian.index') }}" class="row g-2 align-items-end" id="filterForm">
            <div class="col-md-4 col-lg-3">
                <label for="filterSearch" class="form-label small text-muted mb-1">Cari Antrian / Plat / Pemilik</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 12px 0 0 12px; border-color: #cbd5e1;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="filterSearch" name="search" class="form-control border-start-0" placeholder="Cari nomor antrian / plat..." value="{{ request('search') }}" style="border-radius: 0 12px 12px 0;">
                </div>
            </div>
            <div class="col-md-3 col-lg-3">
                <label for="filterTanggal" class="form-label small text-muted mb-1">Filter Tanggal</label>
                <input type="date" id="filterTanggal" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-3 col-lg-3">
                <label for="filterStatus" class="form-label small text-muted mb-1">Status Pelayanan</label>
                <select id="filterStatus" name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" id="btnSubmitFilter">
                    <i class="fas fa-filter me-1"></i> Terapkan Filter
                </button>
                @if(request('search') || request('tanggal') || request('status'))
                    <a href="{{ route('antrian.index') }}" class="btn btn-outline-danger" title="Reset semua filter">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                @endif
            </div>
        </form>

        @if(request('search') || request('tanggal') || request('status'))
            <div class="d-flex align-items-center gap-2 mt-3 pt-2 border-top small text-muted">
                <i class="fas fa-info-circle text-primary"></i>
                <span>Menampilkan hasil filter:</span>
                @if(request('search'))
                    <span class="badge bg-light text-dark border">Kata kunci: "{{ request('search') }}"</span>
                @endif
                @if(request('tanggal'))
                    <span class="badge bg-light text-dark border">Tanggal: {{ \Carbon\Carbon::parse(request('tanggal'))->format('d/m/Y') }}</span>
                @endif
                @if(request('status'))
                    <span class="badge bg-light text-dark border">Status: {{ request('status') }}</span>
                @endif
                <a href="{{ route('antrian.index') }}" class="text-danger text-decoration-none ms-auto fw-semibold">
                    <i class="fas fa-times me-1"></i> Hapus Filter
                </a>
            </div>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:65px; padding-left:1.5rem;">No</th>
                        <th>Nomor Antrian</th>
                        <th>Nomor Polisi</th>
                        <th>Jenis</th>
                        <th>Nama Pemilik</th>
                        <th>Tanggal & Waktu</th>
                        <th>Status</th>
                        <th style="width:140px; text-align:right; padding-right:1.5rem;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($antrians as $index => $antrian)
                        <tr>
                            <td style="padding-left:1.5rem;" class="text-muted fw-semibold">{{ $antrians->firstItem() + $index }}</td>
                            <td>
                                <span class="fw-bold px-2 py-1 rounded-2" style="background:#eff6ff; color:#1d4ed8; font-size:0.95rem;">
                                    {{ $antrian->nomor_antrian }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold" style="color:#0f172a;">{{ $antrian->kendaraan ? $antrian->kendaraan->nomor_polisi : '-' }}</span>
                            </td>
                            <td>
                                <span class="badge" style="background:#eff6ff; color:#1d4ed8; font-weight:600; padding:0.35rem 0.65rem; border-radius:8px; border:1px solid #bfdbfe;">
                                    {{ $antrian->kendaraan ? $antrian->kendaraan->jenis_kendaraan : '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $antrian->kendaraan ? $antrian->kendaraan->nama_pemilik : '-' }}</span>
                            </td>
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
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('antrian.edit', $antrian) }}" class="btn btn-sm btn-outline-primary" aria-label="Edit antrian {{ $antrian->nomor_antrian }}" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('antrian.destroy', $antrian) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data antrian ini?')" aria-label="Hapus antrian {{ $antrian->nomor_antrian }}" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width:54px; height:54px; border-radius:16px; background:#eff6ff; color:#3b82f6;">
                                    <i class="fas fa-filter fa-2x"></i>
                                </div>
                                <div class="fw-semibold">Tidak ada data antrian yang cocok</div>
                                <div class="small text-muted mt-1">Coba sesuaikan kata kunci pencarian atau ubah filter status/tanggal.</div>
                                @if(request('search') || request('tanggal') || request('status'))
                                    <div class="mt-3">
                                        <a href="{{ route('antrian.index') }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-undo me-1"></i> Reset Semua Filter
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($antrians->hasPages())
        <div class="card-footer bg-white border-0 pt-3 pb-3" style="border-bottom-left-radius:18px; border-bottom-right-radius:18px;">
            {{ $antrians->links() }}
        </div>
    @endif
</div>
@endsection


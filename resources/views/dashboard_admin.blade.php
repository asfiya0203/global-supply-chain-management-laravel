<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Panel - Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-admin-slate">

<div>
    <!-- Page Header Khusus Admin -->
    <div class="admin-header-card p-4 rounded-4 mb-4 text-white shadow-sm position-relative overflow-hidden">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative z-1">
            <div>
                <span class="badge bg-warning text-dark rounded-pill px-3 py-1 text-uppercase fw-bold mb-2" style="font-size: 0.65rem; letter-spacing: 0.08em;">
                    <i class="fa-solid fa-user-shield me-1"></i> Area Administrator
                </span>
                <h2 class="fw-bold mb-1" style="letter-spacing: -0.5px;">Dashboard Sistem & Monitoring</h2>
                <p class="text-white-50 small mb-0">Pusat kendali sinkronisasi data harian, otorisasi pengguna, serta manajemen berita & pelabuhan.</p>
            </div>
            <div>
                <form action="{{ route('admin.update') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-warning rounded-pill px-4 py-2 fw-bold transition-hover d-inline-flex align-items-center gap-2 text-dark shadow-sm">
                        <i class="fa-solid fa-rotate fs-6"></i>
                        <span>Jalankan Sync Harian</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check text-success fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Row 1: Status Sinkronisasi Data & Manajemen Pelabuhan -->
    <div class="row g-4 mb-4">
        <!-- Status Update Data Card -->
        <div class="col-lg-8">
            <div class="card border-0 bg-white rounded-4 overflow-hidden shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
                    <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                        <i class="fa-solid fa-arrows-rotate me-1 text-info"></i> Status Sinkronisasi Otomatis
                    </span>
                    <small class="text-muted" style="font-size: 0.75rem;">Terakhir Diperbarui</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light-custom">
                                <tr class="text-uppercase text-muted small fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                                    <th class="ps-4 py-3" width="60%">Modul Data</th>
                                    <th class="pe-4 py-3 text-end">Waktu Terakhir Sync</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom border-light hover-row">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-shield-halved text-primary opacity-75"></i>
                                            <span class="fw-semibold text-dark">Skor Risiko Harian</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="badge bg-light text-dark border border-light font-monospace px-2 py-1">
                                            {{ $updateTerakhir['skor'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom border-light hover-row">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-coins text-warning opacity-75"></i>
                                            <span class="fw-semibold text-dark">Kurs Mata Uang</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="badge bg-light text-dark border border-light font-monospace px-2 py-1">
                                            {{ $updateTerakhir['kurs'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom border-light hover-row">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-chart-line text-success opacity-75"></i>
                                            <span class="fw-semibold text-dark">Indikator Ekonomi</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="badge bg-light text-dark border border-light font-monospace px-2 py-1">
                                            {{ $updateTerakhir['ekonomi'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="border-bottom border-light hover-row">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-cloud-sun text-info opacity-75"></i>
                                            <span class="fw-semibold text-dark">Data Cuaca</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="badge bg-light text-dark border border-light font-monospace px-2 py-1">
                                            {{ $updateTerakhir['cuaca'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover-row">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-newspaper text-danger opacity-75"></i>
                                            <span class="fw-semibold text-dark">Data Berita Global</span>
                                        </div>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <span class="badge bg-light text-dark border border-light font-monospace px-2 py-1">
                                            {{ $updateTerakhir['berita'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Card: Kelola Pelabuhan -->
        <div class="col-lg-4">
            <div class="card border-0 bg-white rounded-4 p-4 shadow-sm h-100 d-flex flex-column justify-content-between">
                <div>
                    <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide mb-3" style="font-size: 0.65rem;">
                        <i class="fa-solid fa-bolt me-1 text-warning"></i> Quick Action
                    </span>
                    <h4 class="fw-bold text-dark mb-2">Manajemen Pelabuhan</h4>
                    <p class="text-muted small mb-4">Akses langsung untuk memantau, mengupdate seluruh data pelabuhan.</p>
                </div>
                <a href="{{ route('admin.pelabuhan') }}"
                   class="btn btn-purple rounded-4 p-3 text-start transition-hover d-flex align-items-center justify-content-between shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box rounded-3 p-3 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-ship fs-4"></i>
                        </div>
                        <div>
                            <span class="fw-bold d-block">Modul Pelabuhan</span>
                            <small class="text-white-50">Buka Halaman Kelola</small>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Row 2: Data Pengguna Terbaru -->
    <div class="card border-0 bg-white rounded-4 overflow-hidden shadow-sm mb-4">
        <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
            <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                <i class="fa-solid fa-users me-1"></i> Pengguna Terdaftar
            </span>
            <span class="badge bg-light text-dark border border-light rounded-pill px-3 py-1 small fw-bold">
                Total: {{ count($users) }} Pengguna
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light-custom">
                        <tr class="text-uppercase text-muted small fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                            <th class="ps-4 py-3" width="70">No</th>
                            <th class="py-3">Nama Pengguna</th>
                            <th class="pe-4 py-3">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr class="border-bottom border-light hover-row">
                                <td class="ps-4 py-3 text-muted fw-bold small">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-dark text-white fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold text-dark">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 text-muted small">{{ $user->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted small">
                                    <i class="fa-solid fa-user-slash text-muted opacity-25 fs-1 mb-2 d-block"></i>
                                    Belum ada data pengguna terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Row 3: Data Berita Partial -->
    <div class="card border-0 bg-white rounded-4 p-4 shadow-sm mb-4">
        @include('dashboard_admin.data-berita')
    </div>
</div>

<style>
    .bg-admin-slate { background-color: #f4f6f8; }
    .ls-wide { letter-spacing: 0.08em; }
    .bg-light-custom { background-color: #f8f9fa; }

    .admin-header-card {
        background: linear-gradient(135deg, #311046);
    }

    .transition-hover {
        transition: all 0.2s ease-in-out;
    }
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12) !important;
    }

    .hover-row {
        transition: background-color 0.15s ease;
    }
    .hover-row:hover {
        background-color: #f8fafc;
    }

    .btn-purple{
        background: #311046 !important;
        color: #fff !important;
    }

</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
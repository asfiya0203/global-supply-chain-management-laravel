<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pelabuhan</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<div class="container py-4 my-2">

    <!-- Header Page -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">
                <i class="fa-solid fa-ship me-2 text-purple"></i>Kelola Data Pelabuhan
            </h2>
        </div>

        <div>
            <a href="{{ route('admin.dashboard_admin') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session('success'))
        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-check fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-exclamation fs-5 text-danger"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <!-- Data Table Container -->
    <div class="card card-custom bg-white overflow-hidden">
        <div class="card-header bg-transparent border-bottom pt-3 px-4 pb-3 d-flex justify-content-between align-items-center">
            <span class="fw-bold text-dark small text-uppercase" style="letter-spacing: 0.05em;">
                <i class="fa-solid fa-list me-2 text-muted"></i>Daftar Pelabuhan
            </span>
            <span class="badge bg-light text-dark border px-3 py-1 rounded-pill small fw-bold">
                Total: {{ count($pelabuhan) }} Data
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3" width="70">No</th>
                            <th class="py-3">Nama Pelabuhan</th>
                            <th class="py-3">Negara</th>
                            <th class="py-3">Ukuran</th>
                            <th class="py-3">Tipe</th>
                            <th class="pe-4 py-3">Penggunaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pelabuhan as $item)
                            <tr class="hover-row">
                                <td class="ps-4 py-3 fw-bold text-muted small">{{ $loop->iteration }}</td>
                                <td class="py-3 fw-bold text-dark">{{ $item->nama_pelabuhan }}</td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <i class="fa-solid fa-flag me-1 text-muted"></i>{{ $item->negara->nama_negara ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 text-muted small">{{ $item->ukuran_pelabuhan ?? '-' }}</td>
                                <td class="py-3">
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1">
                                        {{ $item->tipe_pelabuhan ?? '-' }}
                                    </span>
                                </td>
                                <td class="pe-4 py-3 text-muted small">{{ $item->penggunaan_pelabuhan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted small">
                                    <i class="fa-solid fa-ship text-muted opacity-25 fs-1 mb-2 d-block"></i>
                                    Belum ada data pelabuhan yang tersimpan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
        body {
            background-color: #f8f9fa;
        }
        .card-custom {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        .table-custom th {
            background: linear-gradient(135deg, #311046, #311046);
            color: #fff;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .hover-row:hover {
            background-color: #f1f5f9;
        }
        
        .text-purple{
            color:#311046;
        }
    </style>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpan Negara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light-custom">

<div class="d-flex">

    @include('partials.sidebar')

    <div class="content flex-grow-1 p-4">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                    <i class="fa-solid fa-bookmark me-1 text-warning"></i> Koleksi Favorit
                </span>
                <h2 class="fw-bold mt-2 mb-1 text-dark" style="letter-spacing: -0.5px;">Simpan Negara</h2>
                <p class="text-muted small mb-0">Kelola dan pantau daftar negara terpilih yang Anda simpan untuk akses cepat.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning border-0 rounded-3 shadow-sm mb-4">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('warning') }}
            </div>
        @endif

        <!-- Table Card: Daftar Negara Tersimpan -->
        <div class="card border-1 border-light bg-white rounded-4 overflow-hidden mb-4">

            <div class="card-header bg-transparent border-bottom border-light pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
                <span class="badge bg-dark rounded-0 px-2 py-1 text-uppercase ls-wide" style="font-size: 0.65rem;">
                    <i class="fa-solid fa-list me-1"></i> Daftar Tersimpan
                </span>
                <span class="badge bg-light text-dark border border-light rounded-pill px-3 py-1 small fw-bold">
                    Total: {{ $favorit->count() }} Negara
                </span>
            </div>

            <div class="card-body p-0">

                @if($favorit->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa-solid fa-folder-open text-muted opacity-25 fs-1 mb-3 d-block"></i>
                        <h6 class="fw-bold text-dark mb-1">Belum ada negara yang disimpan</h6>
                        <p class="text-muted small mb-3">Tambahkan negara dari dashboard untuk melihatnya di sini.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 fw-semibold">
                            Cari Negara Sekarang
                        </a>
                    </div>
                @else

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead class="bg-light-custom">
                                <tr class="text-uppercase text-muted small fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                                    <th class="ps-4 py-3" width="90">Bendera</th>
                                    <th class="py-3">Nama Negara</th>
                                    <th class="py-3 text-center" width="120">Detail</th>
                                    <th class="pe-4 py-3 text-center" width="100">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($favorit as $item)
                                    <tr class="border-bottom border-light hover-row">

                                        <td class="ps-4 py-3">
                                            <img src="{{ $item->negara->bendera }}"
                                                 alt="{{ $item->negara->nama_negara }}"
                                                 class="rounded border border-light shadow-sm"
                                                 width="45" style="object-fit: cover;">
                                        </td>

                                        <td class="py-3">
                                            <span class="fw-bold text-dark d-block mb-0">{{ $item->negara->nama_negara }}</span>
                                        </td>

                                        <td class="py-3 text-center">
                                            <a href="{{ route('dashboard', ['negara' => $item->negara->id]) }}"
                                               class="btn btn-light btn-sm border rounded-pill px-3 fw-semibold text-dark hover-shadow">
                                                <i class="fa-solid fa-eye me-1 text-primary"></i> Lihat
                                            </a>
                                        </td>

                                        <td class="pe-4 py-3 text-center">

                                            <form action="{{ route('favorit.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus negara ini dari favorit?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-light btn-sm border rounded-circle text-danger hover-danger" style="width: 32px; height: 32px; padding: 0;" title="Hapus">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<style>
    .ls-wide { letter-spacing: 0.08em; }
    .bg-light-custom { background-color: #f8f9fa; }
    
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
        background-color: #fcfcfc;
    }

    .hover-danger:hover {
        background-color: #dc3545 !important;
        color: #ffffff !important;
        border-color: #dc3545 !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
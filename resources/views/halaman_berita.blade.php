<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Hari Ini</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-newspaper text-primary me-2"></i>
                Berita Hari Ini
            </h2>
            <p class="text-muted mb-0">
                Menampilkan semua berita logistik, perdagangan, pelayaran, dan ekonomi hari ini.
            </p>
        </div>

        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

<!-- Tab Navigation -->
<ul class="nav nav-tabs mb-3" id="beritaTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="umum-tab" data-bs-toggle="tab"
                data-bs-target="#umum" type="button" role="tab">
            <i class="fa-solid fa-newspaper me-1"></i>
            Berita Umum ({{ $berita->count() }})
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link" id="bencana-tab" data-bs-toggle="tab"
                data-bs-target="#bencana" type="button" role="tab">
            <i class="fa-solid fa-triangle-exclamation me-1"></i>
            Bencana ({{ $bencana->count() }})
        </button>
    </li>
</ul>

<div class="tab-content" id="beritaTabContent">

    <!-- TAB BERITA UMUM -->
    <div class="tab-pane fade show active" id="umum" role="tabpanel">

        @forelse($berita as $item)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge bg-primary text-uppercase">
                                {{ $item->kategori }}
                            </span>

                            @if($item->sentimen == 'positif')
                                <span class="badge bg-success">Positif</span>
                            @elseif($item->sentimen == 'negatif')
                                <span class="badge bg-danger">Negatif</span>
                            @else
                                <span class="badge bg-secondary">Netral</span>
                            @endif
                        </div>

                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y H:i') }}
                        </small>
                    </div>

                    <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $item->negara->nama_negara ?? 'Tidak diketahui' }}
                        </small>

                        <a href="{{ $item->url }}" target="_blank"
                           class="btn btn-primary btn-sm">
                            Baca Berita
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="alert alert-secondary">
                Belum ada berita umum hari ini.
            </div>
        @endforelse

    </div>

    <!-- TAB BENCANA -->
    <div class="tab-pane fade" id="bencana" role="tabpanel">

        @forelse($bencana as $item)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge bg-danger text-uppercase">
                                {{ $item->jenis_bencana }}
                            </span>

                            <span class="badge bg-dark">
                                Risiko {{ $item->skor_risiko_bencana }}
                            </span>
                        </div>

                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d M Y H:i') }}
                        </small>
                    </div>

                    <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>

                    <div class="row g-2 mb-3">
                        <div class="col-md-4 col-6">
                            <div class="border rounded p-2 text-center">
                                <small class="text-muted d-block">Skor Negatif</small>
                                <strong class="text-danger">{{ $item->skor_negatif }}</strong>
                            </div>
                        </div>

                        <div class="col-md-4 col-6">
                            <div class="border rounded p-2 text-center">
                                <small class="text-muted d-block">Risiko Bencana</small>
                                <strong>{{ $item->skor_risiko_bencana }}</strong>
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="border rounded p-2 text-center">
                                <small class="text-muted d-block">Sumber</small>
                                <strong>{{ $item->sumber }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            {{ $item->negara->nama_negara ?? 'Tidak diketahui' }}
                        </small>

                        <a href="{{ $item->url }}" target="_blank"
                           class="btn btn-danger btn-sm">
                            Baca Berita
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="alert alert-secondary">
                Belum ada berita bencana hari ini.
            </div>
        @endforelse

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
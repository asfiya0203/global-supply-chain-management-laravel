<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tren</title>

```
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<!-- Select2 CSS ← TAMBAHKAN DI SINI -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
```

</head>

<body>

<div class="d-flex">

```
<!-- Sidebar -->
@include('partials.sidebar')

<!-- Content -->
<div class="content flex-grow-1 p-4">

    <h2 class="mb-4">
        <i class="fa-solid fa-chart-line me-2"></i>
        Halaman Tren Global
    </h2>

    <div class="mb-4">
    <label class="form-label fw-bold">Pilih Negara</label>
    <select class="form-select" id="negara-tren" name="negara_id">
        <option value="">Pilih Negara</option>
        @foreach($negara as $item)
            <option value="{{ $item->id }}">
                {{ $item->nama_negara }}
            </option>
        @endforeach
    </select>
</div>
    <div id="konten-tren" style="display:none;">

        <div class="row">

            <!-- Grafik Skor Risiko -->
            <div class="col-lg-12 mb-4">
                <div class="card shadow border-0">
                    <div class="card-header bg-header-custom">
                        <i class="fa-solid fa-shield-halved me-2"></i>
                        <strong>Tren Skor Risiko</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikSkorRisiko" height="120"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Kurs -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-header-custom">
                        <i class="fa-solid fa-coins me-2"></i>
                        <strong>Tren Kurs Mata Uang</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikKurs" height="220"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik GDP -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-header-custom">
                        <i class="fa-solid fa-chart-bar me-2"></i>
                        <strong>Tren GDP</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikGdp" height="220"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Inflasi -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-header-custom">
                        <i class="fa-solid fa-chart-line me-2"></i>
                        <strong>Tren Inflasi</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikInflasi" height="220"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Populasi -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow border-0 h-100">
                    <div class="card-header bg-header-custom">
                        <i class="fa-solid fa-users me-2"></i>
                        <strong>Tren Populasi</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="grafikPopulasi" height="220"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
```

</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

{{-- Select2 — TAMBAHKAN INI --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- APP_URL --}}
<script>
    const APP_URL = {
        ekonomi : "{{ url('/api/ekonomi') }}",
        kurs    : "{{ url('/api/kurs') }}",
        skorRisiko : "{{ url('/api/skor-risiko/grafik') }}",
        ekonomiGrafikGdp      : "{{ url('/api/ekonomi/grafik/gdp') }}",
        ekonomiGrafikInflasi  : "{{ url('/api/ekonomi/grafik/inflasi') }}",
        ekonomiGrafikPopulasi : "{{ url('/api/ekonomi/grafik/populasi') }}"
    };
</script>

{{-- JS --}}
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/ekonomi.js') }}"></script>
<script src="{{ asset('js/kurs.js') }}"></script>
<script src="{{ asset('js/risiko.js') }}"></script>

</body>
</html>

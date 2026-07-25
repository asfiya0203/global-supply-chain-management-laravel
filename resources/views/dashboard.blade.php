<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring Negara</title>

    {{-- CSS Libraries (Hanya di sini satu kali) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
<div class="d-flex">
    {{-- 1. Sidebar --}}
    @include('partials.sidebar')

    <div class="content flex-grow-1 p-4">
        <h2 class="mb-4">Dashboard</h2>

        {{-- 2. Input Utama (Global Control) --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Pilih Negara</label>
            <select class="form-select" id="negara" name="negara_id">
                <option value="">Pilih Negara</option>
                @foreach($negara as $item)
                    <option
                        value="{{ $item->id }}"
                        {{ ($selectedNegara ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_negara }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 3. Area Detail Negara --}}
        <div id="detail-negara" class="mb-4" style="display:none;">
            
            {{-- Loading Spinner --}}
            <div id="loading-negara" class="text-center py-4" style="display:none;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Memuat data negara...</p>
            </div>

            {{-- Penempelan Potongan Puzzle (Partials) --}}
            <div id="konten-negara">
                @include('dashboard.partials.card-identitas')
                @include('dashboard.partials.card-skor-risiko')
                @include('dashboard.partials.card-cuaca')

                <div class="row">
                    @include('dashboard.partials.card-ekonomi')
                    @include('dashboard.partials.card-kurs')
                </div>
                @include('dashboard.partials.card-visualisasi-data')
            </div>
            
        </div>

        {{-- 4. Peta (Selalu muncul) --}}
        @include('dashboard.partials.card-peta')
    </div>
</div>

{{-- JS Libraries (Hanya di sini satu kali) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const APP_URL = {
        koordinat : "{{ route('peta.koordinat') }}",
        detail    : "{{ url('/api/negara') }}",
        cuaca     : "{{ url('/api/cuaca') }}",
        ekonomi   : "{{ url('/api/ekonomi') }}",
        kurs      : "{{ url('/api/kurs') }}",
        skorRisiko: "{{ url('/api/skor-risiko') }}",
        muatGrafikSkorRisiko : "{{ url('/api/skor-risiko/grafik') }}",
        ekonomiGrafikGdp      : "{{ url('/api/ekonomi/grafik/gdp') }}",
        ekonomiGrafikInflasi  : "{{ url('/api/ekonomi/grafik/inflasi') }}",
        ekonomiGrafikPopulasi : "{{ url('/api/ekonomi/grafik/populasi') }}"
    };
</script>

{{-- JS Logic Dashboard --}}
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/cuaca.js') }}"></script>
<script src="{{ asset('js/ekonomi.js') }}"></script>
<script src="{{ asset('js/kurs.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/risiko.js') }}"></script>

</body>
</html>
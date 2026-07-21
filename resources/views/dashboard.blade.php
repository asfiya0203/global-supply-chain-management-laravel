<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<div class="d-flex">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Content --}}
    <div class="content flex-grow-1 p-4">

        <h2 class="mb-4">Dashboard</h2>
        {{-- Combobox --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Pilih Negara</label>
            <select class="form-select" id="negara" name="negara_id">
                <option value="">Pilih Negara</option>
                @foreach($negara as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nama_negara }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Section detail negara (awalnya tersembunyi) --}}
        <div id="detail-negara" class="mb-4" style="display:none;">

            {{-- Loading spinner --}}
            <div id="loading-negara" class="text-center py-4" style="display:none;">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-2 text-muted">Memuat data negara...</p>
            </div>

            {{-- Konten detail --}}
            <div id="konten-negara">

                {{-- Kartu identitas negara --}}
                <div class="card shadow">
                    <div class="card-header bg-header-custom">
                        <span id="detail-nama"></span>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img id="detail-bendera"
                                     src=""
                                     alt="Bendera"
                                     style="height:60px; border:1px solid #ddd; border-radius:4px;">
                            </div>
                            <div class="col">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted" width="130">Ibu Kota</td>
                                        <td><strong id="detail-ibukota"></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Wilayah</td>
                                        <td><strong id="detail-wilayah"></strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Kode ISO</td>
                                        <td><strong id="detail-iso"></strong></td>
                                    </tr>
                                </table>
                                <!-- Tombol Simpan Negara -->
                                <form action="{{ route('favorit.store') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="negara_id" id="favorit-negara-id">
                                
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-bookmark me-2"></i>
                                        Simpan Negara
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><br>

                <div class="row">

                    {{-- Kartu Indikator Ekonomi --}}
                    <div class="col-lg-6 mb-3">

                        <div class="card shadow border-0 h-100">

                            <div class="card-header bg-header-custom d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fa-solid fa-chart-line me-2"></i>
                                    <strong>Indikator Ekonomi</strong>
                                </span>

                                <small id="ekonomi-tahun" class="fw-normal"></small>
                            </div>

                            <div class="card-body">

                                <div class="row py-2">
                                    <div class="col-md-4 fw-semibold">
                                        <i class="fa-solid fa-money-bill-trend-up me-2"></i>
                                        GDP
                                    </div>

                                    <div class="col-md-8 text-end fw-bold" id="detail-gdp">
                                        -
                                    </div>
                                </div>

                                <hr>

                                <div class="row py-2">
                                    <div class="col-md-4 fw-semibold">
                                        <i class="fa-solid fa-money-bill-trend-up me-2"></i>
                                        Inflasi
                                    </div>

                                    <div class="col-md-8 text-end fw-bold" id="detail-inflasi">
                                        -
                                    </div>
                                </div>

                                <hr>

                                <div class="row py-2">
                                    <div class="col-md-4 fw-semibold">
                                        <i class="fa-solid fa-users me-2"></i>
                                        Populasi
                                    </div>

                                    <div class="col-md-8 text-end fw-bold" id="detail-populasi">
                                        -
                                    </div>
                                </div>

                                <hr>

                                <div class="row py-2">
                                    <div class="col-md-4 fw-semibold">
                                        <i class="fa-solid fa-box text-info me-2"></i>
                                        Ekspor
                                    </div>

                                    <div class="col-md-8 text-end fw-bold" id="detail-ekspor">
                                        -
                                    </div>
                                </div>

                                <hr>

                                <div class="row py-2">
                                    <div class="col-md-4 fw-semibold">
                                        <i class="fa-solid fa-ship text-danger me-2"></i>
                                        Impor
                                    </div>

                                    <div class="col-md-8 text-end fw-bold" id="detail-impor">
                                        -
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Kartu Kurs Mata Uang --}}
                    <div class="col-lg-6 mb-3">

                        <div class="card shadow border-0 h-100">

                            <div class="card-header bg-header-custom d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fa-solid fa-coins me-2"></i>
                                    <strong>Kurs Mata Uang</strong>
                                </span>

                                <small id="kurs-tanggal" class="fw-normal"></small>
                            </div>

                            <div class="card-body">

                                <div id="loading-kurs" class="text-center py-3" style="display:none;">
                                    <div class="spinner-border spinner-border-sm text-primary"></div>
                                    <span class="ms-2 text-muted">Memuat data kurs...</span>
                                </div>

                                <div id="konten-kurs">

                                    <div class="row py-2">
                                        <div class="col-md-4 fw-semibold">
                                            <i class="fa-solid fa-tag me-2"></i>
                                            Kode Mata Uang
                                        </div>

                                        <div class="col-md-8 text-end fw-bold" id="detail-kode-mata-uang">
                                            -
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row py-2">
                                        <div class="col-md-4 fw-semibold">
                                            <i class="fa-solid fa-dollar-sign me-2"></i>
                                            1 USD =
                                        </div>

                                        <div class="col-md-8 text-end fw-bold" id="detail-kurs">
                                            -
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row py-2">
                                        <div class="col-md-4 fw-semibold">
                                            <i class="fa-solid fa-arrow-trend-up me-2"></i>
                                            Perubahan
                                        </div>

                                        <div class="col-md-8 text-end fw-bold" id="detail-perubahan-kurs">
                                            -
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row py-2">
                                        <div class="col-md-4 fw-semibold">
                                            <i class="fa-solid fa-chart-line me-2"></i>
                                            Tren
                                        </div>

                                        <div class="col-md-8 text-end fw-bold" id="detail-tren-kurs">
                                            -
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row py-2">
                                        <div class="col-md-4 fw-semibold">
                                            <i class="fa-solid fa-shield-halved me-2"></i>
                                            Tingkat Risiko
                                        </div>

                                        <div class="col-md-8 text-end">
                                            <span class="badge" id="detail-risiko-kurs">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--KARTU CUACA DI SINI--}}
                <div class="card shadow mb-3">
                    <div class="card-header bg-header-custom">
                        <i class="fa-solid fa-cloud-sun"></i> Cuaca Saat Ini
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted" width="160">Suhu</td>
                                <td><strong id="detail-suhu">-</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Curah Hujan</td>
                                <td><strong id="detail-hujan">-</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kecepatan Angin</td>
                                <td><strong id="detail-angin">-</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Kondisi</td>
                                <td><strong id="detail-kondisi">-</strong></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Tingkat Risiko Cuaca</td>
                                <td>
                                    <span class="badge" id="detail-risiko-cuaca">-</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        {{-- Card Peta --}}
        <div class="card shadow">
            <div class="card-header bg-header-custom">
                <i class="fa-solid fa-earth-americas"></i>
                Peta Monitoring Negara
            </div>
            <div class="card-body p-2">
                <div id="map"></div>
            </div>
        </div>
    </div>

</div>

{{-- JQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

{{-- Select2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Leaflet --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Passing URL dari Laravel ke JS --}}
<script>
    const APP_URL = {
        koordinat : "{{ route('peta.koordinat') }}",
        detail    : "{{ url('/api/negara') }}",
        cuaca     : "{{ url('/api/cuaca') }}",
        ekonomi   : "{{ url('/api/ekonomi') }}",
        kurs      : "{{ url('/api/kurs') }}",
    };
</script>

{{-- Baru load file JS --}}
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/cuaca.js') }}"></script>
<script src="{{ asset('js/ekonomi.js') }}"></script>
<script src="{{ asset('js/kurs.js') }}"></script>

</body>
</html>
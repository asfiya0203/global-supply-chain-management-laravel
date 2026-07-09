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
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fa-solid fa-flag"></i>
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
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Card Peta --}}
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
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

{{-- Passing URL dari Laravel ke JS --}}
<script>
    const APP_URL = {
        koordinat : "{{ route('peta.koordinat') }}",
        detail    : "{{ url('/api/negara') }}"
    };
</script>

{{-- Baru load file JS --}}
<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>
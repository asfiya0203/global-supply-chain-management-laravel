<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Pelabuhan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="bg-light">

<div class="d-flex">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="content flex-grow-1 p-4">

        <h2 class="mb-4">
            <i class="fa-solid fa-ship me-2"></i>
            Peta Pelabuhan Negara
        </h2>

        {{-- Combobox Pilih Negara --}}
        <div class="mb-4">
            <label class="form-label fw-bold">Pilih Negara</label>
            <select class="form-select" id="negara-pelabuhan">
                <option value="">Pilih Negara</option>
                @foreach($negara as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nama_negara }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Card Peta --}}
        <div class="card shadow">
            <div class="card-header bg-header-custom">
                <i class="fa-solid fa-earth-americas"></i>
                Peta Pelabuhan Negara
            </div>
            <div class="card-body p-2">
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Inisialisasi Select2
    $('#negara-pelabuhan').select2({
        placeholder: "Cari negara...",
        allowClear: true,
        width: '100%'
    });

    // Inisialisasi peta
    let map = L.map('map').setView([0, 0], 2);

    L.tileLayer(
        'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);

    // Layer untuk marker pelabuhan
    let markers = L.featureGroup().addTo(map);

    // Event ketika negara dipilih
    $('#negara-pelabuhan').on('change', function () {

        let negaraId = $(this).val();

        // Hapus semua marker lama
        markers.clearLayers();

        if (!negaraId) {
            map.setView([0, 0], 2);
            return;
        }

        // Ambil data pelabuhan berdasarkan negara
        fetch(`/api/pelabuhan/${negaraId}`)
            .then(response => response.json())
            .then(data => {

                if (data.length === 0) {
                    alert('Tidak ada data pelabuhan untuk negara ini.');
                    map.setView([0, 0], 2);
                    return;
                }

                data.forEach(item => {

                    let marker = L.marker([
                        item.latitude,
                        item.longitude
                    ])
                    .bindPopup(`
                        <strong>${item.nama_pelabuhan}</strong><br>
                        Koordinat: ${item.latitude}, ${item.longitude}
                    `);

                    markers.addLayer(marker);

                });

                // Zoom ke semua marker
                map.fitBounds(markers.getBounds());

            })
            .catch(error => {
                console.error('Gagal memuat data pelabuhan:', error);
            });

    });

});
</script>

</body>
</html>
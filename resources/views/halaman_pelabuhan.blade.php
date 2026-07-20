<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Pelabuhan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-bold">Peta Pelabuhan Dunia</h2>
        <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div id="map"></div>
        </div>
    </div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    let map = L.map('map').setView([0, 0], 2);

    L.tileLayer(
        'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);

    let markers = L.featureGroup();

    @foreach($pelabuhan as $item)

        var marker = L.marker([
            {{ $item->latitude }},
            {{ $item->longitude }}
        ])
        .addTo(map)
        .bindPopup(`
            <strong>{{ $item->nama_pelabuhan }}</strong><br>
            Negara: {{ $item->negara->nama_negara }}<br>
            Koordinat: {{ $item->latitude }}, {{ $item->longitude }}
        `);

        markers.addLayer(marker);

    @endforeach

    if (markers.getLayers().length > 0) {
        map.fitBounds(markers.getBounds());
    }

});
</script>

</body>
</html>
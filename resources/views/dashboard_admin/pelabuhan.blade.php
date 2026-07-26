<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kelola pelabuhan</title>
</head>
<body class="bg-light">

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-ship me-2 text-primary"></i>
                Kelola Data Pelabuhan
            </h2>
            <p class="text-muted mb-0">
                Update data pelabuhan dan lihat persebarannya pada peta.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>
            Kembali
        </a>

    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tombol Update --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-1">
                    <i class="fa-solid fa-rotate me-2"></i>
                    Update Data Pelabuhan
                </h5>

                <small class="text-muted">
                    Klik tombol untuk mengambil data pelabuhan terbaru dari API.
                </small>
            </div>

            <form action="{{ route('admin.pelabuhan.update') }}" method="POST">
                @csrf

                <button class="btn btn-primary">
                    <i class="fa-solid fa-cloud-arrow-down me-2"></i>
                    Update Harian
                </button>

            </form>

        </div>

    </div>

<table class="table table-striped table-hover align-middle">

<thead class="table-dark">

<tr>

    <th>No</th>
    <th>Nama Pelabuhan</th>
    <th>Negara</th>
    <th>Ukuran</th>
    <th>Tipe</th>
    <th>Penggunaan</th>

</tr>

</thead>

<tbody>

@foreach($pelabuhan as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $item->nama_pelabuhan }}</td>

    <td>{{ $item->negara->nama_negara }}</td>

    <td>{{ $item->ukuran_pelabuhan }}</td>

    <td>{{ $item->tipe_pelabuhan }}</td>

    <td>{{ $item->penggunaan_pelabuhan }}</td>

</tr>

@endforeach

</tbody>

</table>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</html>
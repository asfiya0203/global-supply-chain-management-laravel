<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

```
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
    body {
        background: #f5f7fb;
    }

    .navbar {
        box-shadow: 0 2px 10px rgba(0, 0, 0, .1);
    }

    .card {
        border: none;
        border-radius: 15px;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }

    .table th {
        white-space: nowrap;
    }

    .btn {
        border-radius: 8px;
    }

    .stat-card h2 {
        font-weight: bold;
    }
</style>
```

</head>

<body>

```
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard Admin
        </a>

        <div class="ms-auto">
            <a href="{{ url('/') }}" class="btn btn-light btn-sm">
                <i class="bi bi-house"></i>
                Beranda
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid py-4">

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

    <h2 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Dashboard Admin
    </h2>

    {{-- CARD STATISTIK --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow border-0 bg-primary text-white stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill"></i>
                    <h5>Total User</h5>
                    <h2>{{ $totalUser }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-success text-white stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-globe-americas"></i>
                    <h5>Total Negara</h5>
                    <h2>{{ $totalNegara }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-warning text-dark stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h5>Total Pelabuhan</h5>
                    <h2>{{ $totalPelabuhan }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 bg-danger text-white stat-card">
                <div class="card-body text-center">
                    <i class="bi bi-newspaper"></i>
                    <h5>Total Berita</h5>
                    <h2>{{ $totalBerita }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- TABEL USER --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-people-fill"></i>
                User Terbaru
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    Tidak ada data user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- TABEL PELABUHAN --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-geo-alt-fill"></i>
                Pelabuhan Terbaru
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Nama Pelabuhan</th>
                            <th>Negara</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pelabuhan as $item)
                            <tr>
                                <td>{{ $item->nama_pelabuhan }}</td>
                                <td>{{ $item->negara->nama_negara ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">
                                    Tidak ada data pelabuhan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- TABEL BERITA --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="bi bi-newspaper"></i>
                Berita Terbaru
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Negara</th>
                            <th>Tanggal</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($berita as $item)
                            <tr>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->negara->nama_negara ?? '-' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->format('d-m-Y') }}
                                </td>
                                <td>

                                    @if($item->url)
                                        <a href="{{ $item->url }}"
                                           target="_blank"
                                           class="btn btn-sm btn-primary mb-1">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                        </a>
                                    @endif

                                    <form action="{{ route('admin.berita.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger mb-1"
                                                onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Tidak ada data berita.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
```

</body>

</html>

<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<body>
<div class="container py-4">

    <h2 class="mb-4">Dashboard Admin</h2>

    {{-- =========================
        STATUS UPDATE DATA
    ========================== --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Status Data Terakhir Diperbarui</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th width="60%">Jenis Data</th>
                        <th>Tanggal Terakhir</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Skor Risiko Harian</td>
                        <td>{{ $updateTerakhir['skor'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Kurs Mata Uang</td>
                        <td>{{ $updateTerakhir['kurs'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Indikator Ekonomi</td>
                        <td>{{ $updateTerakhir['ekonomi'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Data Cuaca</td>
                        <td>{{ $updateTerakhir['cuaca'] ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td>Data Berita</td>
                        <td>{{ $updateTerakhir['berita'] ?? '-' }}</td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div>

    <form action="{{ route('admin.update') }}" method="POST">
        @csrf
    
        <button type="submit" class="btn btn-primary">
            Update Harian
        </button>
    </form>

    {{-- =========================
        DATA USER
    ========================== --}}
    <div class="card mb-4">

        <div class="card-header">
            <h5 class="mb-0">Data Pengguna Terbaru</h5>
        </div>

        <div class="card-body">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $index => $user)

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center">
                                Belum ada data pengguna.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.pelabuhan') }}" class="btn btn-success w-100 py-3">
            <i class="fa-solid fa-ship mb-2 d-block fs-3"></i>
            Kelola Pelabuhan
        </a>
    </div>

    {{-- =========================
            DATA BERITA
    ========================== --}}
    <div class="content flex-grow-1 p-4">
    @include('dashboard_admin.data-berita')
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

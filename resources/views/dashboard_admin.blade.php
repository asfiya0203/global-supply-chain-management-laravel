<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard_admin</title>
</head>
<body>
    <h1>DASHBOARD ADMIN</h1>

    <h2>Data Pengguna</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
        </tr>

        @foreach($pengguna as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
        </tr>
        @endforeach
    </table><br>

    @if(session('success'))

    <div class="alert alert-success">
        <h5>{{ session('success') }}</h5>
        <p>
            Negara berhasil diproses :
            <strong>{{ session('negara_berhasil') }}</strong><br>

            Total record diperbarui :
            <strong>{{ session('record_berhasil') }}</strong><br>

            Negara gagal :
            <strong>{{ session('negara_gagal_jumlah') }}</strong>
        </p>
        @if(count(session('negara_gagal', [])) > 0)
        <hr>
        <strong>Daftar negara yang gagal:</strong>
        <ul>
            @foreach(session('negara_gagal') as $item)
                <li>
                    {{ $item['negara'] }} - {{ $item['pesan'] }}
                </li>
            @endforeach
        </ul>
        @endif
    </div>

    @endif

    <form action="{{ route('admin.ekonomi.update') }}" method="POST"
          onsubmit="return confirm('Perbarui data ekonomi dari World Bank? Proses ini mungkin memerlukan beberapa menit.')">
        @csrf

        <button type="submit" class="btn btn-warning">
            <i class="fa-solid fa-arrows-rotate me-2"></i>
            Perbarui Data Ekonomi
        </button>
    </form><br>

    {{-- Notifikasi hasil refresh kurs --}}
    @if(session('success_kurs'))

    <div class="alert alert-success">
        <h5>{{ session('success_kurs') }}</h5>
        <p>
            Negara berhasil diproses :
            <strong>{{ session('negara_berhasil_kurs') }}</strong><br>

            Total record diperbarui :
            <strong>{{ session('record_berhasil_kurs') }}</strong><br>

            Negara gagal :
            <strong>{{ session('negara_gagal_jumlah_kurs') }}</strong>
        </p>

        @if(count(session('negara_gagal_kurs', [])) > 0)
        <hr>
        <strong>Daftar negara yang gagal:</strong>
        <ul>
            @foreach(session('negara_gagal_kurs') as $item)
                <li>{{ $item['negara'] }} - {{ $item['pesan'] }}</li>
            @endforeach
        </ul>
        @endif

    </div>

    @endif

    {{-- Form refresh kurs --}}
    <form action="{{ route('admin.kurs.update') }}" method="POST"
          onsubmit="return confirm('Perbarui data kurs 14 hari terakhir? Proses ini mungkin memerlukan beberapa menit.')">
        @csrf

        <button type="submit" class="btn btn-warning">
            <i class="fa-solid fa-arrows-rotate me-2"></i>
            Perbarui Data Kurs
        </button>
    </form>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-coins text-warning me-2"></i>
                        Update Kurs Mata Uang
                    </h5>
                    <small class="text-muted">
                        Mengambil kurs terbaru dari Open ER API dan memperbarui database.
                    </small>
                </div>

                <form action="{{ route('admin.kurs.update') }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="btn btn-success"
                        onclick="return confirm('Yakin ingin memperbarui data kurs hari ini?')">

                        <i class="fas fa-sync-alt me-2"></i>
                        Update Kurs Hari Ini

                    </button>
                </form>

            </div>

            @if(session('success'))
                <div class="alert alert-success mt-4 mb-0">
                    <strong>{{ session('success') }}</strong><br>

                    Negara berhasil :
                    <strong>{{ session('negara_berhasil') }}</strong><br>

                    Record berhasil :
                    <strong>{{ session('record_berhasil') }}</strong><br>

                    Negara gagal :
                    <strong>{{ session('negara_gagal_jumlah') }}</strong>

                    @if(session('negara_gagal_jumlah') > 0)
                        <hr>

                        <strong>Daftar Negara Gagal :</strong>

                        <ul class="mb-0 mt-2">
                            @foreach(session('negara_gagal') as $item)
                                <li>
                                    {{ $item['negara'] }}
                                    — {{ $item['pesan'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

        </div>
    </div>
</body>
</html>
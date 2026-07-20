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

    {{-- Notifikasi hasil update --}}
@if(session('update_selesai'))
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">

    <h5 class="fw-bold mb-3">
        <i class="fa-solid fa-circle-check me-2"></i>
        Update Harian Selesai
    </h5>

    <div class="row g-3">

        {{-- Hasil cuaca --}}
        <div class="col-md-6">
            <div class="p-3 bg-white rounded border">
                <div class="fw-semibold mb-2">
                    <i class="fa-solid fa-cloud-sun me-1 text-info"></i>
                    Data Cuaca
                </div>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Berhasil</td>
                        <td>
                            <strong class="text-success">
                                {{ session('cuaca_berhasil') }} record
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Gagal</td>
                        <td>
                            <strong class="text-danger">
                                {{ session('cuaca_gagal') }} negara
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu</td>
                        <td>{{ session('cuaca_diperbarui_pada') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Hasil kurs --}}
        <div class="col-md-6">
            <div class="p-3 bg-white rounded border">
                <div class="fw-semibold mb-2">
                    <i class="fa-solid fa-coins me-1 text-warning"></i>
                    Data Kurs Mata Uang
                </div>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Berhasil</td>
                        <td>
                            <strong class="text-success">
                                {{ session('kurs_berhasil') }} negara
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Gagal</td>
                        <td>
                            <strong class="text-danger">
                                {{ session('kurs_gagal') }} negara
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu</td>
                        <td>{{ session('kurs_diperbarui_pada') }}</td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Kartu tombol update harian --}}
<div class="card shadow border-0 mb-4">
    <div class="card-header bg-header-custom">
        <i class="fa-solid fa-rotate me-2"></i>
        <strong>Update Data Harian</strong>
    </div>
    <div class="card-body">

        <p class="text-muted mb-1">
            Perbarui data <strong>cuaca</strong> dan <strong>kurs mata uang</strong>
            untuk semua negara hari ini sekaligus.
        </p>

        <p class="text-muted small mb-3">
            <i class="fa-solid fa-clock me-1"></i>
            Proses ini memerlukan beberapa menit tergantung jumlah negara.
        </p>

        <form action="{{ route('admin.update.harian') }}"
              method="POST"
              id="form-update-harian"
              onsubmit="return konfirmasiUpdate()">
            @csrf

            <button type="submit"
                    class="btn btn-primary"
                    id="btn-update-harian">
                <i class="fa-solid fa-rotate me-2"></i>
                Perbarui Cuaca &amp; Kurs Sekarang
            </button>

        </form>

        {{-- Loading setelah tombol diklik --}}
        <div id="loading-update-harian" class="mt-3" style="display:none;">
            <div class="d-flex align-items-center gap-2">
                <div class="spinner-border spinner-border-sm text-primary"></div>
                <span class="text-muted">
                    Sedang memperbarui data cuaca dan kurs...
                    Jangan tutup halaman ini.
                </span>
            </div>
        </div>

    </div>
</div><br>

<!-- Tombol Update Berita -->
<form action="{{ route('admin.berita.update') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-newspaper me-1"></i>
        Update Berita Hari Ini
    </button>
</form>

<!-- Pesan berhasil -->
@if(session('success'))
    <div class="alert alert-success mt-3">
        <h6 class="mb-2">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </h6>

        <table class="table table-sm table-borderless mb-0">
            <tr>
                <td width="180">Berita berhasil</td>
                <td>: {{ session('berita_berhasil') }} berita</td>
            </tr>
            <tr>
                <td>Berita gagal</td>
                <td>: {{ session('berita_gagal') }} berita</td>
            </tr>
            <tr>
                <td>Waktu update</td>
                <td>: {{ now()->format('d M Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
@endif

<!-- Pesan gagal -->
@if(session('error'))
    <div class="alert alert-danger mt-3">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        {{ session('error') }}
    </div>
@endif


<form action="{{ route('admin.bencana.update') }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-danger">
        <i class="fa-solid fa-triangle-exclamation me-1"></i>
        Update Bencana Hari Ini
    </button>
</form>
{{-- Script untuk tombol update harian --}}
<script>
function konfirmasiUpdate() {
 
    const konfirmasi = confirm(
        'Perbarui data cuaca dan kurs mata uang untuk semua negara?\n\n' +
        'Proses ini memerlukan beberapa menit.\n' +
        'Jangan tutup halaman selama proses berjalan.'
    );

    if (konfirmasi) {
        // Nonaktifkan tombol dan tampilkan loading
        document.getElementById('btn-update-harian').disabled = true;
        document.getElementById('btn-update-harian').innerHTML =
            '<i class="fa-solid fa-rotate fa-spin me-2"></i> Sedang memperbarui...';
        document.getElementById('loading-update-harian').style.display = 'block';
    }

    return konfirmasi;
}
</script>

</body>
</html>
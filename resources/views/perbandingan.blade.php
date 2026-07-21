<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbandingan Negara</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="d-flex">

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Content -->
    <div class="content flex-grow-1 p-4">

        <h2 class="mb-4">
            <i class="fa-solid fa-chart-bar me-2"></i>
            Perbandingan Negara
        </h2>

        <div class="card shadow border-0">

            <div class="card-header bg-header-custom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fa-solid fa-scale-balanced me-2"></i>
                    Pilih Dua Negara
                </h5>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('perbandingan') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-5">
                            <label class="form-label fw-bold">Negara 1</label>
                            <select name="negara1" class="form-select" required>
                                <option value="">Pilih Negara</option>
                                @foreach ($daftarNegara as $negara)
                                    <option value="{{ $negara->id }}"
                                        {{ request('negara1') == $negara->id ? 'selected' : '' }}>
                                        {{ $negara->nama_negara }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold">Negara 2</label>
                            <select name="negara2" class="form-select" required>
                                <option value="">Pilih Negara</option>
                                @foreach ($daftarNegara as $negara)
                                    <option value="{{ $negara->id }}"
                                        {{ request('negara2') == $negara->id ? 'selected' : '' }}>
                                        {{ $negara->nama_negara }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-warning w-100 fw-bold">
                                <i class="fa-solid fa-scale-balanced me-2"></i>
                                Bandingkan
                            </button>
                        </div>

                    </div>
                </form>

                <hr>

                @if ($country1 && $country2)

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-warning text-center">
                                <tr>
                                    <th style="width: 25%;">Data</th>
                                    <th>{{ $country1->nama_negara }}</th>
                                    <th>{{ $country2->nama_negara }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td class="fw-semibold">Bendera</td>
                                    <td class="text-center">
                                        <img src="{{ $country1->bendera }}"
                                             alt="{{ $country1->nama_negara }}"
                                             width="80">
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ $country2->bendera }}"
                                             alt="{{ $country2->nama_negara }}"
                                             width="80">
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">GDP</td>
                                    <td>{{ $ekonomi1->gdp ?? '-' }}</td>
                                    <td>{{ $ekonomi2->gdp ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Inflasi</td>
                                    <td>
                                        {{ isset($ekonomi1->inflasi) ? number_format($ekonomi1->inflasi, 2) . ' %' : '-' }}
                                    </td>
                                    <td>
                                        {{ isset($ekonomi2->inflasi) ? number_format($ekonomi2->inflasi, 2) . ' %' : '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Populasi</td>
                                    <td>{{ $ekonomi1->populasi ?? '-' }}</td>
                                    <td>{{ $ekonomi2->populasi ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Cuaca</td>
                                    <td>{{ $weather1->suhu ?? '-' }} °C</td>
                                    <td>{{ $weather2->suhu ?? '-' }} °C</td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Kondisi Cuaca</td>
                                    <td>{{ $weather1->kondisi_cuaca ?? '-' }}</td>
                                    <td>{{ $weather2->kondisi_cuaca ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Skor Risiko</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark">
                                            {{ $risk1->skor_total ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark">
                                            {{ $risk2->skor_total ?? '-' }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Tingkat Risiko</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            {{ $risk1->tingkat_risiko ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">
                                            {{ $risk2->tingkat_risiko ?? '-' }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold">Mata Uang</td>
                                    <td>{{ $country1->kode_mata_uang ?? '-' }}</td>
                                    <td>{{ $country2->kode_mata_uang ?? '-' }}</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="alert alert-info mb-0">
                        <i class="fa-solid fa-circle-info me-2"></i>
                        Silakan pilih dua negara untuk dibandingkan.
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
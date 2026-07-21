<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpan Negara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="d-flex">

    @include('partials.sidebar')

    <div class="content flex-grow-1 p-4">

        <h2 class="mb-4">
            <i class="fa-solid fa-bookmark me-2"></i>
            Simpan Negara
        </h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <div class="card shadow border-0">

            <div class="card-header bg-header-custom">
                <strong>Daftar Negara Tersimpan</strong>
            </div>

            <div class="card-body">

                @if($favorit->isEmpty())
                    <div class="alert alert-info mb-0">
                        Belum ada negara yang disimpan.
                    </div>
                @else

                    <div class="table-responsive">

                        <table class="table table-bordered align-middle">

                            <thead class="table-warning">
                                <tr>
                                    <th>Bendera</th>
                                    <th>Nama Negara</th>
                                    <th>Wilayah</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($favorit as $item)
                                    <tr>

                                        <td width="80">
                                            <img src="{{ $item->negara->bendera }}"
                                                 alt="{{ $item->negara->nama_negara }}"
                                                 width="50">
                                        </td>

                                        <td>
                                            <strong>{{ $item->negara->nama_negara }}</strong>
                                        </td>

                                        <td>{{ $item->negara->wilayah }}</td>

                                        <td class="text-center">

                                            <form action="{{ route('favorit.destroy', $item->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus negara ini dari favorit?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
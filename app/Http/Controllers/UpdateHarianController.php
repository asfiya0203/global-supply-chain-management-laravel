<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use App\Services\BeritaService;
use App\Services\BeritaBencanaService;
use App\Services\SkorRisikoService;
use App\Models\DataCuaca;

class UpdateHarianController extends Controller
{
    protected $beritaService;
    protected $beritaBencanaService;
    protected $skorRisikoService;

    public function __construct(
        BeritaService        $beritaService,
        BeritaBencanaService $beritaBencanaService,
        SkorRisikoService    $skorRisikoService
    ) {
        $this->beritaService        = $beritaService;
        $this->beritaBencanaService = $beritaBencanaService;
        $this->skorRisikoService    = $skorRisikoService;
    }

    // =====================================================
    // DIPANGGIL OTOMATIS — dari HalamanController
    // saat admin buka dashboard, hanya kalau belum update hari ini
    // =====================================================
    public function cekDanUpdate()
    {
        // Cek apakah sudah ada data cuaca hari ini
        $sudahUpdate = DataCuaca::whereDate('tanggal_data', today())->exists();

        if ($sudahUpdate) {
            // Sudah ada data hari ini — tidak perlu update lagi
            return;
        }

        // Belum ada — jalankan semua update
        $this->jalankanSemuaUpdate();
    }

    // =====================================================
    // TOMBOL MANUAL — Update Cuaca + Kurs
    // =====================================================
    public function updateCuacaKurs()
    {
        Artisan::call('cuaca:update');
        $outputCuaca = Artisan::output();

        Artisan::call('kurs:frankfurter');
        $outputKurs = Artisan::output();

        preg_match('/Negara gagal\s*:\s*(\d+)/', $outputCuaca, $cuacaGagal);
        $jumlahCuacaGagal = $cuacaGagal[1] ?? 0;

        preg_match('/Record gagal\s*:\s*(\d+)/', $outputKurs, $kursGagal);
        $jumlahKursGagal = $kursGagal[1] ?? 0;

        $totalGagal = $jumlahCuacaGagal + $jumlahKursGagal;

        $pesan = $totalGagal == 0
            ? 'Semua negara berhasil diperbarui untuk data cuaca dan kurs.'
            : "Update selesai dengan {$totalGagal} data gagal diperbarui.";

        return redirect()->back()->with(['success' => $pesan]);
    }

    // =====================================================
    // TOMBOL MANUAL — Update Berita Ekonomi saja
    // =====================================================
    public function updateBeritaEkonomi()
    {
        $hasil = $this->beritaService->updateBerita();

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$hasil['berhasil']} berita ekonomi hari ini.",
        ]);
    }

    // =====================================================
    // TOMBOL MANUAL — Update Berita Bencana saja
    // =====================================================
    public function updateBeritaBencana()
    {
        $hasil = $this->beritaBencanaService->updateBeritaBencana();

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$hasil['berhasil']} berita bencana hari ini.",
        ]);
    }

    // =====================================================
    // TOMBOL MANUAL — Update Berita (Ekonomi + Bencana)
    // =====================================================
    public function updateBerita()
    {
        $hasilBerita  = $this->beritaService->updateBerita();
        $hasilBencana = $this->beritaBencanaService->updateBeritaBencana();

        $totalBerita = $hasilBerita['berhasil'] + $hasilBencana['berhasil'];

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$totalBerita} berita hari ini (ekonomi + bencana).",
        ]);
    }

    // =====================================================
    // TOMBOL MANUAL — Update Semua + Hitung Skor
    // =====================================================
    public function update()
    {
        $this->jalankanSemuaUpdate();

        return redirect()->back()->with([
            'success' => 'Semua data berhasil diperbarui dan skor risiko telah dihitung.'
        ]);
    }

    // =====================================================
    // PRIVATE — logika update semua (dipakai oleh
    // cekDanUpdate() dan update() supaya tidak duplikat)
    // =====================================================
    private function jalankanSemuaUpdate()
    {
        // 1. Cuaca
        Artisan::call('cuaca:update');

        // 2. Kurs
        Artisan::call('kurs:frankfurter');

        // 3. Berita ekonomi
        Artisan::call('berita:update', ['tipe' => 'berita']);

        // 4. Berita bencana
        Artisan::call('berita:update', ['tipe' => 'bencana']);

        // 5. Hitung skor risiko dari semua data yang sudah masuk
        $this->skorRisikoService->hitungSemuaSkorRisiko();
    }
}
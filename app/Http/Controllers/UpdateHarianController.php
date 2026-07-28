<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use App\Services\BeritaService;
use App\Services\BeritaBencanaService;
use App\Services\SkorRisikoService;
use App\Models\DataCuaca;
use App\Models\KursMataUang;
use App\Models\IndikatorEkonomi;
use App\Models\DataBencana;
use App\Models\DataBerita;
use App\Models\SkorRisikoHarian;

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

    public function cekDanUpdate()
    {
        $sudahUpdate = DataCuaca::whereDate('tanggal_data', today())->exists();

        if ($sudahUpdate) {
            return;
        }
        $this->jalankanSemuaUpdate();
    }

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

    public function updateBeritaEkonomi()
    {
        $hasil = $this->beritaService->updateBerita();

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$hasil['berhasil']} berita ekonomi hari ini.",
        ]);
    }

    public function updateBeritaBencana()
    {
        $hasil = $this->beritaBencanaService->updateBeritaBencana();

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$hasil['berhasil']} berita bencana hari ini.",
        ]);
    }

    public function updateBerita()
    {
        $hasilBerita  = $this->beritaService->updateBerita();
        $hasilBencana = $this->beritaBencanaService->updateBeritaBencana();

        $totalBerita = $hasilBerita['berhasil'] + $hasilBencana['berhasil'];

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$totalBerita} berita hari ini (ekonomi + bencana).",
        ]);
    }

    public function update()
    {
        $cuaca = DataCuaca::whereDate('tanggal_data', today())->exists();

        $kurs = KursMataUang::whereDate('tanggal', today())->exists();

        $berita = DataBerita::whereDate('tanggal_publikasi', today())->exists();

        $bencana = DataBencana::whereDate('tanggal_publikasi', today())->exists();

        $skor = SkorRisikoHarian::whereDate('tanggal', today())->exists();

        // Jika semua data hari ini sudah ada
        if ($cuaca && $kurs && $berita && $bencana && $skor) {
            return redirect()->back()->with([
                'success' => 'Data hari ini sudah diperbarui. Tidak ada proses update yang dijalankan.'
            ]);
        }
    
        // Jalankan update
        $this->jalankanSemuaUpdate();
    
        return redirect()->back()->with([
            'success' => 'Semua data berhasil diperbarui dan skor risiko telah dihitung.'
        ]);
    }

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
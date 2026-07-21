<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use App\Services\BeritaService;
use App\Services\BeritaBencanaService;
use App\Services\SkorRisikoService;

class UpdateHarianController extends Controller
{
    protected $beritaService;
    protected $beritaBencanaService;
    protected $skorRisikoService;

    public function __construct(
        BeritaService $beritaService,
        BeritaBencanaService $beritaBencanaService,
        SkorRisikoService $skorRisikoService
    ) {
        $this->beritaService = $beritaService;
        $this->beritaBencanaService = $beritaBencanaService;
        $this->skorRisikoService = $skorRisikoService;
    }

    public function updateCuacaKurs()
    {
        // Jalankan command cuaca
        Artisan::call('cuaca:update');
        $outputCuaca = Artisan::output();
   
        Artisan::call('kurs:frankfurter');
        $outputKurs = Artisan::output();

        preg_match('/Negara gagal\s*:\s*(\d+)/', $outputCuaca, $cuacaGagal);
        $jumlahCuacaGagal = $cuacaGagal[1] ?? 0;
    
        preg_match('/Record gagal\s*:\s*(\d+)/', $outputKurs, $kursGagal);
        $jumlahKursGagal = $kursGagal[1] ?? 0;
    
        $totalGagal = $jumlahCuacaGagal + $jumlahKursGagal;
    
        if ($totalGagal == 0) {
            $pesan = 'Semua negara berhasil diperbarui untuk data cuaca dan kurs.';
        } else {
            $pesan = "Update selesai dengan {$totalGagal} data gagal diperbarui.";
        }
    
        return redirect()->back()->with([
            'success' => $pesan,
        ]);
    }

    // Tombol Update Berita
    public function updateBerita()
    {
        $hasilBerita = $this->beritaService->updateBerita();
        $hasilBencana = $this->beritaBencanaService->updateBeritaBencana();

        $totalBerita = $hasilBerita['berhasil'] + $hasilBencana['berhasil'];

        return redirect()->back()->with([
            'success' => "Berhasil memperbarui {$totalBerita} berita hari ini.",
        ]);
    }

    public function update()
    {
        // Update cuaca dan kurs
        Artisan::call('cuaca:update');
        Artisan::call('kurs:frankfurter');

        // Update berita dan bencana
        $this->beritaService->updateBerita();
        $this->beritaBencanaService->updateBeritaBencana();

        // Setelah semua data selesai, hitung skor risiko otomatis
        $this->skorRisikoService->hitungSemuaSkorRisiko();

        return redirect()->back()->with([
            'success' => 'Semua data berhasil diperbarui dan skor risiko telah dihitung otomatis.'
        ]);
    }
}
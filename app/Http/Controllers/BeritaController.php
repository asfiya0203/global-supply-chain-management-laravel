<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BeritaService;
use App\Services\BeritaBencanaService;

class BeritaController extends Controller
{
protected $beritaService;
protected $beritaBencanaService;

    public function __construct(
        BeritaService $beritaService,
        BeritaBencanaService $beritaBencanaService
    ) {
        $this->beritaService = $beritaService;
        $this->beritaBencanaService = $beritaBencanaService;
    }

    public function updateBerita()
    {
        $hasil = $this->beritaService->updateBerita();

        return redirect()->back()->with([
            'success' => 'Update berita berhasil dilakukan.',
            'berita_berhasil' => $hasil['berhasil'],
            'berita_gagal' => $hasil['gagal'],
        ]);
    }

    public function updateBencana()
    {
        $hasil = $this->beritaBencanaService->updateBeritaBencana();

        return redirect()->back()->with([
            'success' => 'Update berita bencana berhasil dilakukan.',
            'berita_bencana_berhasil' => $hasil['berhasil'],
            'berita_bencana_gagal' => $hasil['gagal'],
        ]);
    }
    
}

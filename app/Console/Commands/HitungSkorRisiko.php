<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SkorRisikoService;

class HitungSkorRisiko extends Command
{
    protected $signature = 'skor:update {tanggal?}';
    protected $description = 'Menghitung dan memperbarui skor risiko harian';

    public function handle(SkorRisikoService $service)
    {
        $tanggalMulai = $this->argument('tanggal') ?? '2026-07-11';
        $tanggalHariIni = now()->format('Y-m-d');

        $this->info("Memulai perhitungan skor risiko dari {$tanggalMulai} sampai {$tanggalHariIni}...");
        $tanggal = \Carbon\Carbon::parse($tanggalMulai);

        while ($tanggal->format('Y-m-d') <= $tanggalHariIni) {
            $service->hitungSemuaSkorRisiko($tanggal->format('Y-m-d'));
            $this->info("Tanggal {$tanggal->format('Y-m-d')} selesai dihitung");
            $tanggal->addDay();
        }

        $this->info('Perhitungan skor risiko selesai.');
        return Command::SUCCESS;
    }
}
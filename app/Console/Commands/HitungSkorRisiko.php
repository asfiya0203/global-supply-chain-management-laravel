<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SkorRisikoService;
use Carbon\Carbon;

class HitungSkorRisiko extends Command
{
    protected $signature = 'skor:update {mulai?} {akhir?}';

    protected $description = 'Menghitung dan memperbarui skor risiko harian';

    public function handle(SkorRisikoService $service)
    {
        $mulai = $this->argument('mulai') ?? '2026-07-24';
        $akhir = $this->argument('akhir') ?? now()->format('Y-m-d');

        $tanggal = Carbon::parse($mulai);

        while ($tanggal->lte(Carbon::parse($akhir))) {

            $service->hitungSemuaSkorRisiko($tanggal->format('Y-m-d'));

            $this->info("Selesai: ".$tanggal->format('Y-m-d'));

            $tanggal->addDay();
        }

        $this->info('Perhitungan skor risiko selesai.');

        return Command::SUCCESS;
    }
}
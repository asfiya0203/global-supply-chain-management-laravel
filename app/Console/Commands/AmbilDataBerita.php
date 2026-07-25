<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BeritaService;
use App\Services\BeritaBencanaService;

class AmbilDataBerita extends Command
{
    protected $signature = 'berita:update {tipe?}';
    protected $description = 'Update berita atau berita bencana';

    public function handle(
        BeritaService $beritaService,
        BeritaBencanaService $bencanaService
    ) {
        $tipe = $this->argument('tipe');

        switch ($tipe) {

            case 'berita':
                return $this->updateBerita($beritaService);

            case 'bencana':
                return $this->updateBeritaBencana($bencanaService);

            default:
                $this->error('Gunakan: berita atau bencana');
                return Command::FAILURE;
        }
    }

    /**
     * Update Berita Geopolitik
     */
    public function updateBerita(BeritaService $service)
    {
        $this->info('Mengambil berita...');

        $hasil = $service->updateBerita($this);

        $this->info('Berhasil : '.$hasil['berhasil']);
        $this->info('Gagal    : '.$hasil['gagal']);

        return Command::SUCCESS;
    }

    /**
     * Update Berita Bencana
     */
    public function updateBeritaBencana(BeritaBencanaService $service)
    {
        $this->info('Mengambil berita bencana...');

        $hasil = $service->updateBeritaBencana($this);

        $this->info('Berhasil : '.$hasil['berhasil']);
        $this->info('Gagal    : '.$hasil['gagal']);

        return Command::SUCCESS;
    }
}
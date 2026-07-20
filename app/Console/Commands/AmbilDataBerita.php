<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BeritaService;

class AmbilDataBerita extends Command
{
    protected $signature = 'berita:update';
    protected $description = 'Mengambil data berita hari ini dari GNews';

    public function handle(BeritaService $service)
    {
        $this->info('Memulai update berita...');

        $hasil = $service->updateBerita($this);

        $this->info('Update selesai');
        $this->info('Berhasil: ' . $hasil['berhasil']);
        $this->info('Gagal: ' . $hasil['gagal']);

        return Command::SUCCESS;
    }
}
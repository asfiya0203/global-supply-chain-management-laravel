<?php

namespace App\Console\Commands;

use App\Models\Negara;
use App\Services\RestCountriesService;
use Illuminate\Console\Command;

class AmbilDataNegara extends Command
{
    protected $signature = 'sync:negara';
    protected $description = 'Sinkronisasi 50 negara dari countries.dev ke database';
    public function handle(RestCountriesService $service)
    {
        $this->info('Mengambil data 50 negara...');

        $daftarNegara = $service->ambilSemuaNegara();

        if (empty($daftarNegara)) {
            $this->error('Tidak ada data yang berhasil diambil.');
            return Command::FAILURE;
        }

        $jumlahBaru = 0;
        $jumlahUpdate = 0;

        $bar = $this->output->createProgressBar(count($daftarNegara));
        $bar->start();

        foreach ($daftarNegara as $data) {

            if (empty($data['kode_iso2'])) {
                $bar->advance();
                continue;
            }

            $negara = Negara::updateOrCreate(
                [
                    'kode_iso2' => $data['kode_iso2']
                ],
                $data
            );

            if ($negara->wasRecentlyCreated) {
                $jumlahBaru++;
            } else {
                $jumlahUpdate++;
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);
        $this->info("Sinkronisasi selesai.");
        $this->info("Negara baru : {$jumlahBaru}");
        $this->info("Negara update : {$jumlahUpdate}");
        $this->info("Total diproses : " . count($daftarNegara));

        return Command::SUCCESS;
    }
}
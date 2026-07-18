<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\IndikatorEkonomi;

class AmbilDataEkonomi extends Command
{
    protected $signature = 'ekonomi:ambil';
    protected $description = 'Ambil data ekonomi dari World Bank API';

    public function handle()
    {
        $this->info('Mulai sinkronisasi data ekonomi...');
        $this->newLine();

        $indikator = [
            'gdp'      => 'NY.GDP.MKTP.CD',
            'inflasi'  => 'FP.CPI.TOTL.ZG',
            'populasi' => 'SP.POP.TOTL',
            'ekspor'   => 'NE.EXP.GNFS.CD',
            'impor'    => 'NE.IMP.GNFS.CD',
        ];

        $semuaNegara = Negara::where('id', '>', 5)->get();

        $berhasil = 0;
        $gagal = 0;
        $negaraBerhasil = 0;

        $this->info("Total negara : {$semuaNegara->count()}");
        $this->newLine();

        foreach ($semuaNegara as $negara) {
            $this->line("Memproses {$negara->nama_negara}");
            $dataPerTahun = [];
            foreach ($indikator as $kolom => $kodeWB) {

                try {
                    $response = Http::retry(3, 2000)
                        ->timeout(30)
                        ->get("https://api.worldbank.org/v2/country/{$negara->kode_iso2}/indicator/{$kodeWB}",
                            [
                                'format'   => 'json',
                                'mrv'      => 5,
                                'per_page' => 5,
                            ]
                        );

                    if ($response->failed()) {
                        throw new \Exception("HTTP Error {$response->status()}");
                    }
                    $json = $response->json();
                    if (!isset($json[1])) {
                        throw new \Exception("Data kosong");
                    }
                    foreach ($json[1] as $baris) {
                        $tahun = $baris['date'] ?? null;
                        if (!$tahun) {
                            continue;
                        }
                        $dataPerTahun[$tahun][$kolom] = $baris['value'];
                    }

                } catch (\Exception $e) {
                    $this->warn("   Gagal {$kolom} : {$e->getMessage()}");
                    $gagal++;
                }
            }

            foreach ($dataPerTahun as $tahun => $data) {
                IndikatorEkonomi::updateOrCreate(
                    [
                        'negara_id' => $negara->id,
                        'tahun'     => $tahun,
                    ],
                    [
                        'gdp'        => $data['gdp'] ?? null,
                        'inflasi'    => $data['inflasi'] ?? null,
                        'populasi'   => $data['populasi'] ?? null,
                        'ekspor'     => $data['ekspor'] ?? null,
                        'impor'      => $data['impor'] ?? null,
                        'sumber_api' => 'World Bank',
                    ]
                );

                $berhasil++;
            }

            if (!empty($dataPerTahun)) {
                $negaraBerhasil++;
            }

            sleep(1);
        }

        $this->newLine();
        $this->info("==================================");
        $this->info("SELESAI");
        $this->info("==================================");
        $this->info("Negara berhasil : {$negaraBerhasil}");
        $this->info("Record berhasil : {$berhasil}");
        $this->warn("Record gagal    : {$gagal}");
        $this->info("==================================");
        return Command::SUCCESS;
    }
}
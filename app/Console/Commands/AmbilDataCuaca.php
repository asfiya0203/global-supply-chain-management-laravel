<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\DataCuaca;
use Carbon\Carbon;

class AmbilDataCuaca extends Command
{
    protected $signature = 'cuaca:update';
    protected $description = 'Mengambil data cuaca terbaru dari Open-Meteo';

    public function handle()
    {
        $semuaNegara = Negara::all();
        $tanggalMulai = Carbon::yesterday()->format('Y-m-d');
        $tanggalAkhir = Carbon::yesterday()->format('Y-m-d');

        foreach ($semuaNegara as $negara) {$this->info("Mengambil data cuaca {$negara->nama_negara}");

    try {
        $response = Http::timeout(30)->get('https://archive-api.open-meteo.com/v1/archive',
            [
                'latitude'   => $negara->latitude,
                'longitude'  => $negara->longitude,
                'start_date' => $tanggalMulai,
                'end_date'   => $tanggalAkhir,

                'daily' => implode(',', [
                    'temperature_2m_max',
                    'precipitation_sum',
                    'wind_speed_10m_max',
                    'weather_code',
                ]),
                'timezone' => 'auto',
            ]
        );

        $json = $response->json();

            if (!isset($json['daily'])) {
                $this->warn("Data cuaca kosong {$negara->nama_negara}");
                continue;
            }
            
            $daily = $json['daily'];

        foreach ($daily['time'] as $i => $tanggal) {
                $suhu   = $daily['temperature_2m_max'][$i] ?? 0;
                $hujan  = $daily['precipitation_sum'][$i] ?? 0;
                $angin  = $daily['wind_speed_10m_max'][$i] ?? 0;
                $kode   = $daily['weather_code'][$i] ?? 0;
                $kondisi = $this->kodeKeCuaca($kode);
                $risiko = $this->hitungRisiko($suhu, $hujan, $angin, $kode);
    
                DataCuaca::updateOrCreate(
                    [
                        'negara_id'    => $negara->id,
                        'tanggal_data' => $tanggal,
                    ],
                    [
                        'suhu'            => $suhu,
                        'curah_hujan'     => $hujan,
                        'kecepatan_angin' => $angin,
                        'kondisi_cuaca'   => $kondisi,
                        'tingkat_risiko'  => $risiko,
                        'sumber_api'      => 'Open-Meteo Archive',
                        'tanggal_data'    => $tanggal,
                    ]
                );
            }
            $this->info("Selesai {$negara->nama_negara}");
    
        } catch (\Exception $e) {
            $this->warn("Timeout {$negara->nama_negara}");
            continue;
        }
        sleep(1);
    }
        $this->info("Semua data cuaca berhasil dimasukkan.");
    }

    private function kodeKeCuaca($kode)
    {
        $list = [
            0  => 'Cerah',
            1  => 'Cerah Berawan',
            2  => 'Berawan',
            3  => 'Mendung',
            45 => 'Berkabut',
            48 => 'Kabut Beku',

            51 => 'Gerimis Ringan',
            53 => 'Gerimis Sedang',
            55 => 'Gerimis Lebat',

            61 => 'Hujan Ringan',
            63 => 'Hujan Sedang',
            65 => 'Hujan Lebat',

            71 => 'Salju Ringan',
            73 => 'Salju Sedang',
            75 => 'Salju Lebat',

            80 => 'Hujan Singkat',
            81 => 'Hujan Lebat Singkat',
            82 => 'Hujan Sangat Lebat',

            95 => 'Badai Petir',
            96 => 'Badai Petir + Hujan Es',
            99 => 'Badai Petir Hebat',
        ];
        return $list[$kode] ?? 'Tidak Diketahui';
    }

    private function hitungRisiko($suhu, $hujan, $angin, $kode)
    {
        $skor = 0;

        // Suhu
        if ($suhu >= 40 || $suhu <= -10) {
            $skor += 3;
        } elseif ($suhu >= 35 || $suhu <= 0) {
            $skor += 2;
        } else {
            $skor += 1;
        }

        // Curah Hujan
        if ($hujan >= 50) {
            $skor += 3;
        } elseif ($hujan >= 20) {
            $skor += 2;
        } else {
            $skor += 1;
        }

        // Kecepatan Angin
        if ($angin >= 60) {
            $skor += 3;
        } elseif ($angin >= 30) {
            $skor += 2;
        } else {
            $skor += 1;
        }

        // Kondisi Cuaca
        if ($kode >= 95) {
            $skor += 3;
        } elseif ($kode >= 61) {
            $skor += 2;
        } else {
            $skor += 1;
        }
        if ($skor >= 10) {
            return 'tinggi';
        }
        if ($skor >= 7) {
            return 'sedang';
        }
        return 'rendah';
    }
}

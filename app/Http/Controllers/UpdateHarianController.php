<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\DataCuaca;
use App\Models\KursMataUang;
use Carbon\Carbon;

class UpdateHarianController extends Controller
{
    public function update()
    {
        $hasilCuaca = $this->updateCuaca();
        $hasilKurs  = $this->updateKurs();

        return redirect()->back()->with([
            // Cuaca
            'cuaca_berhasil'       => $hasilCuaca['berhasil'],
            'cuaca_gagal'          => $hasilCuaca['gagal'],
            'cuaca_diperbarui_pada' => $hasilCuaca['diperbarui_pada'],

            // Kurs
            'kurs_berhasil'        => $hasilKurs['berhasil'],
            'kurs_gagal'           => $hasilKurs['gagal'],
            'kurs_diperbarui_pada' => $hasilKurs['diperbarui_pada'],

            // Status gabungan
            'update_selesai'       => true,
        ]);
    }

    // =====================================================
    // UPDATE CUACA — Open-Meteo Archive API
    // =====================================================
    private function updateCuaca()
    {
        $tanggalKemarin = Carbon::yesterday()->format('Y-m-d');
        $semuaNegara    = Negara::all();
        $berhasil       = 0;
        $gagal          = 0;

        foreach ($semuaNegara as $negara) {
            try {
                $response = Http::timeout(30)->get('https://archive-api.open-meteo.com/v1/archive',
               [
                   'latitude'   => $negara->latitude,
                   'longitude'  => $negara->longitude,
                   'start_date' => $tanggalKemarin,
                   'end_date'   => $tanggalKemarin,
                   'daily'      => implode(',', [
                    'temperature_2m_max',
                    'precipitation_sum',
                    'wind_speed_10m_max',
                    'weather_code',
                   ]),
                   'timezone'   => 'auto',
               ]
            );

                if ($response->failed()) {throw new \Exception("HTTP Error: " . $response->status());}
                $json = $response->json();
                if (!isset($json['daily'])) {$gagal++; continue;}
                $daily = $json['daily'];
                foreach ($daily['time'] as $i => $tanggal) {

                    $suhu    = $daily['temperature_2m_max'][$i] ?? 0;
                    $hujan   = $daily['precipitation_sum'][$i]  ?? 0;
                    $angin   = $daily['wind_speed_10m_max'][$i] ?? 0;
                    $kode    = $daily['weather_code'][$i]       ?? 0;
                    $kondisi = $this->kodeKeCuaca($kode);
                    $risiko  = $this->hitungRisikoCuaca($suhu, $hujan, $angin, $kode);

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

                    $berhasil++;
                }

            } catch (\Exception $e) {
                $gagal++;
            }

            sleep(1);
        }

        return [
            'berhasil'        => $berhasil,
            'gagal'           => $gagal,
            'diperbarui_pada' => now()->format('d M Y H:i:s'),
        ];
    }

    // =====================================================
    // UPDATE KURS — Open ER API
    // =====================================================
    private function updateKurs()
    {
        $tanggalHariIni = Carbon::today()->format('Y-m-d');
        $berhasil       = 0;
        $gagal          = 0;

        try {

            // Satu panggilan dapat semua mata uang sekaligus
            $response = Http::timeout(30)->get(
                'https://open.er-api.com/v6/latest/USD'
            );

            if ($response->failed()) {
                return [
                    'berhasil'        => 0,
                    'gagal'           => 0,
                    'diperbarui_pada' => now()->format('d M Y H:i:s'),
                ];
            }

            $json      = $response->json();
            $semuaKurs = $json['rates'] ?? [];

            $semuaNegara = Negara::whereNotNull('kode_mata_uang')->get();

            foreach ($semuaNegara as $negara) {

                $kodeMataUang = $negara->kode_mata_uang;

                if (!isset($semuaKurs[$kodeMataUang])) {
                    $gagal++;
                    continue;
                }

                $kursHariIni = $semuaKurs[$kodeMataUang];

                // Ambil kurs kemarin untuk hitung perubahan
                $kursKemarin = KursMataUang::where('negara_id', $negara->id)
                    ->where('tanggal', Carbon::yesterday()->format('Y-m-d'))
                    ->first();

                $perubahanPersen = null;

                if ($kursKemarin && $kursKemarin->kurs_ke_usd > 0) {
                    $perubahanPersen = (
                        ($kursHariIni - $kursKemarin->kurs_ke_usd)
                        / $kursKemarin->kurs_ke_usd
                    ) * 100;
                }

                $tingkatRisiko = $this->hitungRisikoKurs($perubahanPersen);

                KursMataUang::updateOrCreate(
                    [
                        'negara_id' => $negara->id,
                        'tanggal'   => $tanggalHariIni,
                    ],
                    [
                        'kode_mata_uang'   => $kodeMataUang,
                        'kurs_ke_usd'      => $kursHariIni,
                        'perubahan_persen' => $perubahanPersen,
                        'tingkat_risiko'   => $tingkatRisiko,
                        'sumber_api'       => 'Open ER API',
                    ]
                );

                $berhasil++;
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return [
            'berhasil'        => $berhasil,
            'gagal'           => $gagal,
            'diperbarui_pada' => now()->format('d M Y H:i:s'),
        ];
    }

    // =====================================================
    // HELPER — konversi kode cuaca ke label
    // =====================================================
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

    // =====================================================
    // HELPER — hitung risiko cuaca
    // =====================================================
    private function hitungRisikoCuaca($suhu, $hujan, $angin, $kode)
    {
        $skor = 0;

        // Suhu
        if ($suhu >= 40 || $suhu <= -10)     $skor += 3;
        elseif ($suhu >= 35 || $suhu <= 0)   $skor += 2;
        else                                 $skor += 1;

        // Curah Hujan
        if ($hujan >= 50)      $skor += 3;
        elseif ($hujan >= 20)  $skor += 2;
        else                   $skor += 1;

        // Kecepatan Angin
        if ($angin >= 60)      $skor += 3;
        elseif ($angin >= 30)  $skor += 2;
        else                   $skor += 1;

        // Kondisi Cuaca
        if ($kode >= 95)       $skor += 3;
        elseif ($kode >= 61)   $skor += 2;
        else                   $skor += 1;

        if ($skor >= 10) return 'tinggi';
        if ($skor >= 7)  return 'sedang';
        return 'rendah';
    }

    // =====================================================
    // HELPER — hitung risiko kurs
    // =====================================================
    private function hitungRisikoKurs($perubahanPersen)
    {
        if ($perubahanPersen === null) return 'rendah';

        $absolut = abs($perubahanPersen);

        if ($absolut >= 10) return 'kritis';
        if ($absolut >= 5)  return 'tinggi';
        if ($absolut >= 2)  return 'sedang';
        return 'rendah';
    }
}

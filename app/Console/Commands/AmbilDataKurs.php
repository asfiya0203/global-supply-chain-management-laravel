<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\KursMataUang;
use Carbon\Carbon;

class AmbilDataKurs extends Command
{
    protected $signature   = 'kurs:frankfurter';
    protected $description = 'Ambil data kurs 7 hari terakhir dari Frankfurter API';

    private $didukungFrankfurter = [
        'IDR', 'JPY', 'EUR', 'CNY', 'USD',
        'MYR', 'SGD', 'THB', 'PHP', 'KRW',
        'INR', 'CAD', 'MXN', 'BRL', 'GBP',
        'CHF', 'SEK', 'NOK', 'DKK', 'PLN',
        'TRY', 'ZAR', 'AUD', 'NZD', 'HUF',
        'HKD', 'ILS', 'ISK', 'BGN', 'CZK', 'RON',
    ];

    public function handle()
    {
        $tanggalMulai = Carbon::today()->subDays(6)->format('Y-m-d');
        $tanggalAkhir = Carbon::today()->format('Y-m-d');

        $this->info('================================================');
        $this->info('Frankfurter API — Kurs 7 Hari Terakhir');
        $this->info("Rentang: {$tanggalMulai} s/d {$tanggalAkhir}");
        $this->info('================================================');
        $this->newLine();

        $semuaNegara = Negara::whereIn('kode_mata_uang', $this->didukungFrankfurter)
            ->whereNotNull('kode_mata_uang')
            ->get();

        $this->info("Negara yang akan diproses: {$semuaNegara->count()}");
        $this->newLine();
        $this->info("Mengambil data dari Frankfurter API...");

        try {
            $response = Http::timeout(30)->get('https://api.frankfurter.dev/v2/rates',
                [
                    'from' => $tanggalMulai,
                    'to'   => $tanggalAkhir,
                ]
            );

            if ($response->failed()) {
                $this->error("Gagal terhubung ke API: " . $response->status());
                return Command::FAILURE;
            }

            $json = $response->json();
            $dataPerTanggal = [];
            foreach ($json as $item) {
                $tanggal = $item['date'];
                $quote   = $item['quote'];
                $rate    = $item['rate'];

                $dataPerTanggal[$tanggal][$quote] = $rate;
            }

            $this->info("Berhasil ambil data: " . count($dataPerTanggal) . " hari");
            $this->newLine();

        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }

        $berhasil       = 0;
        $gagal          = 0;
        $negaraBerhasil = 0;

        foreach ($semuaNegara as $negara) {
            $this->line("Memproses: {$negara->nama_negara} ({$negara->kode_mata_uang})");
            $kodeMataUang   = $negara->kode_mata_uang;
            $kursSebelumnya = null;
            $adaData        = false;
            ksort($dataPerTanggal);
            foreach ($dataPerTanggal as $tanggal => $kursHariItu) {

                if (!isset($kursHariItu['USD'])) { 
                    continue;
                }
                if ($kodeMataUang === 'EUR') {
                    $kursHariIni = 1.0;
                } elseif (!isset($kursHariItu[$kodeMataUang])) {
                    continue;
                } else {
                    $kursHariIni = $kursHariItu[$kodeMataUang];
                }

                $nilaiUsd  = $kursHariItu['USD'] ?? null;
                $kursKeUsd = ($nilaiUsd && $nilaiUsd > 0)
                    ? $kursHariIni / $nilaiUsd
                    : $kursHariIni;

                $perubahanPersen = null;

                if ($kursSebelumnya !== null && $kursSebelumnya > 0) {
                    $perubahanPersen = (
                        ($kursKeUsd - $kursSebelumnya)
                        / $kursSebelumnya
                    ) * 100;
                }

                $tingkatRisiko = $this->hitungRisikoKurs($perubahanPersen);

                KursMataUang::updateOrCreate(
                    [
                        'negara_id' => $negara->id,
                        'tanggal'   => $tanggal,
                    ],
                    [
                        'kode_mata_uang'   => $kodeMataUang,
                        'kurs_ke_usd'      => $kursKeUsd,
                        'perubahan_persen' => $perubahanPersen,
                        'tingkat_risiko'   => $tingkatRisiko,
                        'sumber_api'       => 'Frankfurter',
                    ]
                );

                $this->info(
                    "  ✓ {$tanggal} → 1 USD = " .
                    number_format($kursKeUsd, 6) .
                    " {$kodeMataUang}" .
                    ($perubahanPersen !== null
                        ? " | Perubahan: " . number_format($perubahanPersen, 2) . "%"
                        : " | Perubahan: -")
                );

                $kursSebelumnya = $kursKeUsd;
                $berhasil++;
                $adaData = true;
            }

            if ($adaData) {
                $negaraBerhasil++;
            }

            $this->newLine();
        }

        $this->info('================================================');
        $this->info('SELESAI');
        $this->info('================================================');
        $this->info("Negara berhasil  : {$negaraBerhasil}");
        $this->info("Record berhasil  : {$berhasil}");
        $this->warn("Record gagal     : {$gagal}");
        $this->info('================================================');

        return Command::SUCCESS;
    }

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
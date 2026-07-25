<?php

namespace App\Services;

use App\Models\Negara;
use App\Models\DataCuaca;
use App\Models\DataBencana;
use App\Models\DataBerita;
use App\Models\KursMataUang;
use App\Models\IndikatorEkonomi;
use App\Models\SkorRisikoHarian;

class SkorRisikoService
{
    public function hitungSemuaSkorRisiko($tanggal = null)
    {
        $tanggal = $tanggal ?? now()->format('Y-m-d');

        foreach (Negara::all() as $negara) {

            // =========================
            // 1. HITUNG SKOR CUACA (1-100)
            // =========================
            $cuaca = DataCuaca::where('negara_id', $negara->id)
                ->whereDate('tanggal_data', $tanggal)
                ->latest('tanggal_data')
                ->first();

            $skorCuaca = $this->hitungSkorCuaca(
                $cuaca->suhu ?? 0,
                $cuaca->curah_hujan ?? 0,
                $cuaca->kecepatan_angin ?? 0
            );

            // =========================
            // 2. SKOR BENCANA (1-100)
            // =========================
            $skorBencana = $this->hitungSkorBencana(
                $negara->id,
                $tanggal
            );

            // =========================
            // 3. SKOR BERITA (1-100)
            // =========================
            $skorBerita = $this->hitungSkorBerita(
                $negara->id,
                $tanggal
            );

            // =========================
            // 4. SKOR KURS (1-100)
            // =========================
            $kurs = KursMataUang::where('negara_id', $negara->id)
                ->whereDate('tanggal', $tanggal)
                ->latest('tanggal')
                ->first();

            $skorKurs = $this->hitungSkorKurs(
                $kurs->perubahan_persen ?? 0
            );

            // =========================
            // 5. SKOR EKONOMI (1-100)
            // =========================
            $ekonomi = IndikatorEkonomi::where('negara_id', $negara->id)
                ->latest('tahun')
                ->first();

            $skorEkonomi = $this->hitungSkorEkonomi(
                $ekonomi->inflasi ?? 0,
                $ekonomi->gdp ?? 0
            );

            // =========================
            // 6. HITUNG SKOR TOTAL BERBOBOT (1-100)
            // =========================
            $skorTotal =
                ($skorCuaca * 0.25) +
                ($skorBencana * 0.25) +
                ($skorBerita * 0.10) +
                ($skorKurs * 0.20) +
                ($skorEkonomi * 0.20);

            // =========================
            // 7. TENTUKAN LEVEL RISIKO
            // =========================
            if ($skorTotal >= 76) {
                $level = 'kritis';
            } elseif ($skorTotal >= 51) {
                $level = 'tinggi';
            } elseif ($skorTotal >= 26) {
                $level = 'sedang';
            } else {
                $level = 'rendah';
            }

            // =========================
            // 8. SIMPAN / UPDATE KE DATABASE
            // =========================
            SkorRisikoHarian::updateOrCreate(
                [
                    'negara_id' => $negara->id,
                    'tanggal' => $tanggal,
                ],
                [
                    'skor_cuaca' => round($skorCuaca, 2),
                    'skor_bencana' => round($skorBencana, 2),
                    'skor_berita' => round($skorBerita, 2),
                    'skor_kurs' => round($skorKurs, 2),
                    'skor_ekonomi' => round($skorEkonomi, 2),
                    'skor_total' => round($skorTotal, 2),
                    'level_risiko' => $level,
                ]
            );
        }
    }

    // =====================================================
    // FUNGSI PERHITUNGAN CUACA (1-100)
    // =====================================================
    private function hitungSkorCuaca($suhu, $curahHujan, $kecepatanAngin)
    {
        // Skor suhu
        if ($suhu > 35) {
            $skorSuhu = 100;
        } elseif ($suhu >= 31) {
            $skorSuhu = 80;
        } elseif ($suhu >= 26) {
            $skorSuhu = 60;
        } elseif ($suhu >= 20) {
            $skorSuhu = 40;
        } else {
            $skorSuhu = 20;
        }

        // Skor curah hujan
        if ($curahHujan > 50) {
            $skorHujan = 100;
        } elseif ($curahHujan > 20) {
            $skorHujan = 80;
        } elseif ($curahHujan > 5) {
            $skorHujan = 60;
        } elseif ($curahHujan > 0) {
            $skorHujan = 30;
        } else {
            $skorHujan = 10;
        }

        // Skor kecepatan angin
        if ($kecepatanAngin > 60) {
            $skorAngin = 100;
        } elseif ($kecepatanAngin > 40) {
            $skorAngin = 90;
        } elseif ($kecepatanAngin > 20) {
            $skorAngin = 70;
        } elseif ($kecepatanAngin >= 10) {
            $skorAngin = 40;
        } else {
            $skorAngin = 20;
        }

        // Bobot: Suhu 30%, Hujan 50%, Angin 20%
        return ($skorSuhu * 0.3) +
               ($skorHujan * 0.5) +
               ($skorAngin * 0.2);
    }

    private function konversiKe100($nilai)
    {
        return match (round($nilai)) {
            1 => 25,
            2 => 50,
            3 => 75,
            4 => 100,
            default => 25,
        };
    }

    // =====================================================
    // PERHITUNGAN SKOR KURS (1-100)
    // =====================================================
    private function hitungSkorKurs($perubahanPersen)
    {
        $perubahan = abs($perubahanPersen);

        if ($perubahan < 0.5) {
            return 10;      
        } elseif ($perubahan < 2) {
            return 20;      
        } elseif ($perubahan < 5) {
            return 45;      
        } elseif ($perubahan < 10) {
            return 70;     
        } else {
            return 90;      
        }
    }

    // =====================================================
    // PERHITUNGAN SKOR EKONOMI (1-100)
    // =====================================================
    private function hitungSkorEkonomi($inflasi, $gdp)
    {
        // Skor inflasi
        if ($inflasi > 10) {
            $skorInflasi = 100;
        } elseif ($inflasi > 5) {
            $skorInflasi = 75;
        } elseif ($inflasi >= 3) {
            $skorInflasi = 50;
        } else {
            $skorInflasi = 25;
        }

        // Skor GDP
        if ($gdp < 0) {
            $skorGdp = 100;
        } elseif ($gdp < 3) {
            $skorGdp = 75;
        } elseif ($gdp < 5) {
            $skorGdp = 50;
        } else {
            $skorGdp = 25;
        }

        // Bobot: Inflasi 70%, GDP 30%
        return ($skorInflasi * 0.7) +
               ($skorGdp * 0.3);
    }


    // =====================================================
    // PERHITUNGAN SKOR BERITA (1-100)
    // =====================================================
    private function hitungSkorBerita($negaraId, $tanggal)
    {
        $berita = DataBerita::where('negara_id', $negaraId)
            ->whereDate('tanggal_publikasi', $tanggal)
            ->get();

        if ($berita->isEmpty()) {
            return 25;
        }

        $total = $berita->count();

        $positif = $berita->where('sentimen', 'positif')->count();
        $netral  = $berita->where('sentimen', 'netral')->count();
        $negatif = $berita->where('sentimen', 'negatif')->count();

        $pctPositif = $positif / $total;
        $pctNetral  = $netral  / $total;
        $pctNegatif = $negatif / $total;

        $skor =
            ($pctPositif * 20) +
            ($pctNetral  * 50) +
            ($pctNegatif * 90);

        return round($skor,2);
    }

    private function hitungSkorBencana($negaraId, $tanggal)
    {
        $bencana = DataBencana::where('negara_id', $negaraId)
            ->whereDate('tanggal_publikasi', $tanggal)
            ->get();
    
        if ($bencana->isEmpty()) {
            return 25;
        }

        // 1. Rata-rata skor negatif
        $rataNegatif = $bencana->avg('skor_negatif');
    
        // Konversi ke 0-100
        if ($rataNegatif >= 10) {
            $skorKeparahan = 100;
        } elseif ($rataNegatif >= 8) {
            $skorKeparahan = 85;
        } elseif ($rataNegatif >= 6) {
            $skorKeparahan = 70;
        } elseif ($rataNegatif >= 4) {
            $skorKeparahan = 55;
        } elseif ($rataNegatif >= 2) {
            $skorKeparahan = 40;
        } else {
            $skorKeparahan = 25;
        }

        // 2. Jumlah berita
        $jumlah = $bencana->count();
    
        if ($jumlah >= 15) {
            $skorJumlah = 100;
        } elseif ($jumlah >= 10) {
            $skorJumlah = 80;
        } elseif ($jumlah >= 6) {
            $skorJumlah = 60;
        } elseif ($jumlah >= 3) {
            $skorJumlah = 40;
        } else {
            $skorJumlah = 20;
        }

        // 3. Skor akhir
        $skor =
            ($skorKeparahan * 0.8) +
            ($skorJumlah * 0.2);
    
        return round($skor, 2);
    }
}
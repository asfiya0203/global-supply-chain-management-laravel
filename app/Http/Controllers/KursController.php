<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\KursMataUang;
use Carbon\Carbon;

class KursController extends Controller
{
    public function ambilSemuaKurs()
    {
        try {
            $response = Http::timeout(30) ->get('https://open.er-api.com/v6/latest/USD');
            if ($response->failed()) {return back()->with('error', 'Gagal mengambil data kurs dari Open ER API.');}
            $json = $response->json();
            if (
                !isset($json['result']) ||
                $json['result'] != 'success' ||
                !isset($json['rates'])
            ) {
                return back()->with('error', 'Data kurs tidak valid.');
            }
            $rates = $json['rates'];
            $tanggalHariIni = Carbon::today()->toDateString();
            $semuaNegara = Negara::whereNotNull('kode_mata_uang')->get();
            $recordBerhasil = 0;
            $negaraBerhasil = 0;
            $negaraGagal = [];

            foreach ($semuaNegara as $negara) {
                $kode = strtoupper($negara->kode_mata_uang);
                if (!isset($rates[$kode])) {
                    $negaraGagal[] = [
                        'negara' => $negara->nama_negara,
                        'pesan' => "Kode {$kode} tidak tersedia"
                    ];
                    continue;
                }

                $kursHariIni = $rates[$kode];
                $dataKemarin = KursMataUang::where('negara_id', $negara->id)
                    ->orderBy('tanggal', 'desc') ->first();

                $perubahan = null;
                if ($dataKemarin && $dataKemarin->kurs_ke_usd > 0) {
                    $perubahan =
                        (($kursHariIni - $dataKemarin->kurs_ke_usd) / $dataKemarin->kurs_ke_usd
                        ) * 100;
                }

                $risiko = $this->hitungRisikoKurs($perubahan);
                KursMataUang::updateOrCreate(
                    [
                        'negara_id' => $negara->id,
                        'tanggal'   => $tanggalHariIni,
                    ],
                    [
                        'kode_mata_uang'   => $kode,
                        'kurs_ke_usd'      => $kursHariIni,
                        'perubahan_persen' => $perubahan,
                        'tingkat_risiko'   => $risiko,
                        'sumber_api'       => 'Open ER API',
                    ]
                );

                $recordBerhasil++;
                $negaraBerhasil++;
            }

            return redirect()->back()->with([
                'success' => 'Sinkronisasi kurs berhasil.',
                'record_berhasil' => $recordBerhasil,
                'negara_berhasil' => $negaraBerhasil,
                'negara_gagal_jumlah' => count($negaraGagal),
                'negara_gagal' => $negaraGagal,
            ]);

        } catch (\Exception $e) {
            return back()->with( 'error', 'Terjadi kesalahan : ' . $e->getMessage());
        }
    }

    // DASHBOARD
    public function kursNegara($id)
    {
        $kurs = KursMataUang::where('negara_id', $id) ->orderByDesc('tanggal')->first();
        if (!$kurs) {return response()->json([
                'sukses' => false,
                'message' => 'Data kurs belum tersedia'
            ], 404);}

        return response()->json([
            'sukses' => true,
            'id' => $kurs->id,
            'negara_id' => $kurs->negara_id,
            'kode_mata_uang' => $kurs->kode_mata_uang,
            'kurs_ke_usd' => $kurs->kurs_ke_usd,
            'perubahan_persen' => $kurs->perubahan_persen,
            'tingkat_risiko' => $kurs->tingkat_risiko,
            'tanggal' => $kurs->tanggal,
            'sumber_api' => $kurs->sumber_api,
        ]);
    }

    // Grafik
    public function trenKurs($id)
    {
        $tren = KursMataUang::where('negara_id', $id)
            ->orderBy('tanggal')->get([
                'tanggal',
                'kurs_ke_usd',
                'perubahan_persen'
            ]);
            
        if ($tren->isEmpty()) {return response()->json([
                'sukses' => false,
                'message' => 'Data belum tersedia'
            ], 404);}

        return response()->json([
            'sukses' => true,
            'data' => $tren
        ]);
    }

    // Hitung Risiko
    private function hitungRisikoKurs($perubahanPersen)
    {
        if ($perubahanPersen === null) {return 'rendah';}
        $nilai = abs($perubahanPersen);
        if ($nilai >= 10) {return 'kritis';}
        if ($nilai >= 5) {return 'tinggi';}
        if ($nilai >= 2) {return 'sedang';}
        return 'rendah';
    }
}

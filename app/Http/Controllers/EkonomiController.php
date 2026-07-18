<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Negara;
use App\Models\IndikatorEkonomi;

class EkonomiController extends Controller
{
    public function ambilSemuaEkonomi()
    {
        $semuaNegara = Negara::all();
        $berhasil    = 0;
        $gagal       = 0;
        $negaraBerhasil = 0;
        $negaraGagal = [];

        $indikator = [
            'gdp'      => 'NY.GDP.MKTP.CD',
            'inflasi'  => 'FP.CPI.TOTL.ZG',
            'populasi' => 'SP.POP.TOTL',
            'ekspor'   => 'NE.EXP.GNFS.CD',
            'impor'    => 'NE.IMP.GNFS.CD',
        ];

        foreach ($semuaNegara as $negara) {
            $dataPerTahun = [];
            foreach ($indikator as $kolom => $kodeWB) {

                try {
                    $response = Http::retry(3, 2000)->timeout(30)
                        ->get(
                            "https://api.worldbank.org/v2/country/{$negara->kode_iso2}/indicator/{$kodeWB}",
                            [
                                'format'   => 'json',
                                'per_page' => 5,
                                'mrv'      => 5,
                            ]);

                    if ($response->failed()) {throw new \Exception("HTTP Error");}
                    $json = $response->json();
                    if (!isset($json[1])) {throw new \Exception("Data kosong");}

                    foreach ($json[1] as $baris) {
                        $tahun = $baris['date'] ?? null;
                        $nilai = $baris['value'] ?? null;
                        if (!$tahun) continue;
                        $dataPerTahun[$tahun][$kolom] = $nilai;
                    }

                } catch (\Exception $e) {
                    if (!collect($negaraGagal)->contains('negara', $negara->nama_negara)) {
                    $gagal++;
                    $negaraGagal[] = ['negara' => $negara->nama_negara,'pesan' => $e->getMessage(),];
                }
                continue;
                }

            }

            foreach ($dataPerTahun as $tahun => $data) {

                IndikatorEkonomi::updateOrCreate(
                    [
                        'negara_id' => $negara->id,
                        'tahun'     => $tahun,
                    ],
                    [
                        'gdp'        => $data['gdp']      ?? null,
                        'inflasi'    => $data['inflasi']  ?? null,
                        'populasi'   => $data['populasi'] ?? null,
                        'ekspor'     => $data['ekspor']   ?? null,
                        'impor'      => $data['impor']    ?? null,
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

        return redirect()->back()->with([
            'success' => 'Sinkronisasi data ekonomi selesai.',
            'negara_berhasil' => $negaraBerhasil,
            'record_berhasil' => $berhasil,
            'negara_gagal_jumlah' => $gagal,
            'negara_gagal' => $negaraGagal,
        ]);
    }
    public function ekonomiNegara($id)
    {
        $terbaru = IndikatorEkonomi::where('negara_id', $id)->orderBy('tahun', 'desc')->first();

        if (!$terbaru) {
            return response()->json(['message' => 'Data ekonomi belum tersedia'], 404);
        }

        return response()->json($terbaru);
    }

    public function trenEkonomi($id)
    {
        $tren = IndikatorEkonomi::where('negara_id', $id)->orderBy('tahun', 'asc')
            ->get([
                'tahun',
                'gdp',
                'inflasi',
                'populasi',
                'ekspor',
                'impor',
            ]);

        if ($tren->isEmpty()) {
            return response()->json(['message' => 'Data tren belum tersedia'], 404);}
        return response()->json($tren);
    }
}

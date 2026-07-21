<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negara;
use App\Models\DataCuaca;
use App\Models\KursMataUang;
use App\Models\IndikatorEkonomi;
use App\Models\DataBencana;
use App\Models\DataBerita;
use App\Models\DataPelabuhan;
use App\Models\SkorRisikoHarian;
use Carbon\Carbon;

class HalamanController extends Controller
{
    public function dashboard()
    {
        $negara = Negara::all();
        return view('dashboard', compact('negara'));
    }

    public function cuacaDetail($id)
    {
        $cuaca = DataCuaca::where('negara_id', $id)
            ->latest('tanggal_data')
            ->first();

        if (!$cuaca) {
            return response()->json([
                'message' => 'Data cuaca tidak ditemukan'
            ], 404);
        }

        return response()->json($cuaca);
    }  

    public function kursDetail($id)
    {
        $kurs = KursMataUang::where('negara_id', $id)
            ->latest('tanggal')
            ->first();
    
        if (!$kurs) {
            return response()->json([
                'sukses' => false,
                'message' => 'Data kurs tidak ditemukan'
            ], 404);
        }
    
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

    public function halamanBerita()
    {
        $berita = DataBerita::with('negara')
            ->whereDate('tanggal_publikasi', Carbon::today())
            ->orderBy('tanggal_publikasi', 'desc')
            ->get();

        $bencana = DataBencana::with('negara')
            ->whereDate('tanggal_publikasi', Carbon::today())
            ->orderBy('tanggal_publikasi', 'desc')
            ->get();

        return view('halaman_berita', compact('berita', 'bencana'));
    }

    public function halamanPelabuhan()
    {
        $negara = Negara::orderBy('nama_negara')->get();
        $pelabuhan = DataPelabuhan::with('negara')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('halaman_pelabuhan', compact('negara', 'pelabuhan'));
    }

    public function pelabuhanByNegara($id)
    {
        $pelabuhan = DataPelabuhan::where('negara_id', $id)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get([
                'id',
                'nama_pelabuhan',
                'latitude',
                'longitude'
            ]);

        return response()->json($pelabuhan);
    }

    public function grafik($negara_id)
    {
        $data = KursMataUang::where('negara_id', $negara_id)
            ->orderBy('tanggal')
            ->get(['tanggal', 'kurs_ke_usd']);
    
        return response()->json($data);
    }
    
    // Grafik GDP
    public function grafikGdp($negara_id)
    {
        $data = IndikatorEkonomi::where('negara_id', $negara_id)
            ->orderBy('tahun', 'asc')
            ->get(['tahun', 'gdp']);
    
        return response()->json($data);
    }
    
    // Grafik Inflasi
    public function grafikInflasi($negara_id)
    {
        $data = IndikatorEkonomi::where('negara_id', $negara_id)
            ->orderBy('tahun', 'asc')
            ->get(['tahun', 'inflasi']);
    
        return response()->json($data);
    }
    
    // Grafik Populasi
    public function grafikPopulasi($negara_id)
    {
        $data = IndikatorEkonomi::where('negara_id', $negara_id)
            ->orderBy('tahun', 'asc')
            ->get(['tahun', 'populasi']);
    
        return response()->json($data);
    }

    // Grafik Skor Risiko
    public function grafikSkorRisiko($negara_id)
    {
        $data = SkorRisikoHarian::where('negara_id', $negara_id)
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal'    => Carbon::parse($item->tanggal)->format('d M'),
                    'skor_total' => $item->skor_total,
                ];
            });
    
        return response()->json($data);
    }  
    
    public function halamanTren()
    {
        $negara = Negara::orderBy('nama_negara')->get();
    
        return view('halaman_tren', compact('negara'));
    }
}

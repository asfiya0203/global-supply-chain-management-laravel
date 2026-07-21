<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negara;
use App\Models\IndikatorEkonomi;
use App\Models\DataCuaca;
use App\Models\SkorRisikoHarian;

class PerbandinganController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar negara untuk combobox
        $daftarNegara = Negara::orderBy('nama_negara')->get();

        $country1 = null;
        $country2 = null;
        $ekonomi1 = null;
        $ekonomi2 = null;
        $weather1 = null;
        $weather2 = null;
        $risk1 = null;
        $risk2 = null;

        // Jika dua negara dipilih
        if ($request->negara1 && $request->negara2) {

            // Ambil data negara
            $country1 = Negara::find($request->negara1);
            $country2 = Negara::find($request->negara2);

            if ($country1 && $country2) {

                // Data ekonomi terbaru
                $ekonomi1 = IndikatorEkonomi::where('negara_id', $country1->id)
                    ->latest('tahun')
                    ->first();

                $ekonomi2 = IndikatorEkonomi::where('negara_id', $country2->id)
                    ->latest('tahun')
                    ->first();

                // Data cuaca terbaru
                $weather1 = DataCuaca::where('negara_id', $country1->id)
                    ->latest('tanggal_data')
                    ->first();

                $weather2 = DataCuaca::where('negara_id', $country2->id)
                    ->latest('tanggal_data')
                    ->first();

                // Skor risiko terbaru
                $risk1 = SkorRisikoHarian::where('negara_id', $country1->id)
                    ->latest('tanggal')
                    ->first();

                $risk2 = SkorRisikoHarian::where('negara_id', $country2->id)
                    ->latest('tanggal')
                    ->first();
            }
        }

        return view('perbandingan', compact(
            'daftarNegara',
            'country1',
            'country2',
            'ekonomi1',
            'ekonomi2',
            'weather1',
            'weather2',
            'risk1',
            'risk2'
        ));
    }
}
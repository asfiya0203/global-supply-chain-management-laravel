<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Negara;

class PetaController extends Controller
{
    public function koordinat()
{
    $negara = Negara::select(
        'id',
        'nama_negara',
        'ibu_kota',
        'latitude',
        'longitude',
        'bendera',
        'wilayah'
    )->get()->map(function ($item) {
        $item->latitude  = (float) $item->latitude;
        $item->longitude = (float) $item->longitude;
        return $item;
    });

    return response()->json($negara);
}

public function detail($id)
{
    $negara = Negara::select(
        'id',
        'nama_negara',
        'kode_iso2',
        'kode_iso3',
        'ibu_kota',
        'wilayah',
        'latitude',
        'longitude',
        'bendera'
    )->find($id);

    if (!$negara) {
        return response()->json([
            'message' => 'Negara tidak ditemukan'
        ], 404);
    }

    $negara->latitude  = (float) $negara->latitude;
    $negara->longitude = (float) $negara->longitude;

    return response()->json($negara);
}
}
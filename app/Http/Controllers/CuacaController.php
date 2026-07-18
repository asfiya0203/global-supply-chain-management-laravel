<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataCuaca;

class CuacaController extends Controller
{
   public function detail($id)
    {
        $cuaca = DataCuaca::where('negara_id', $id)->latest('tanggal_data')->first();

        if (!$cuaca) {
            return response()->json(['message' => 'Data cuaca tidak ditemukan'], 404);
        }
        return response()->json($cuaca);
    }
}

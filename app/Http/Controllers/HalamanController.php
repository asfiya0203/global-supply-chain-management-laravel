<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negara;

class HalamanController extends Controller
{
    public function dashboard()
    {
        $negara = Negara::all();
        return view('dashboard', compact('negara'));
    }
}

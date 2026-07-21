<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\Negara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    // Menampilkan halaman Simpan Negara
    public function index()
    {
        $favorit = Favorit::with('negara')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('halaman_simpan_negara', compact('favorit'));
    }

    // Menyimpan negara ke favorit
    public function store(Request $request)
    {
        $request->validate([
            'negara_id' => 'required|exists:negara,id',
        ]);

        // Cek apakah negara sudah disimpan
        $cek = Favorit::where('user_id', Auth::id())
            ->where('negara_id', $request->negara_id)
            ->first();

        if ($cek) {
            return back()->with('warning', 'Negara sudah ada di daftar favorit.');
        }

        Favorit::create([
            'user_id' => Auth::id(),
            'negara_id' => $request->negara_id,
        ]);

        return back()->with('success', 'Negara berhasil disimpan.');
    }

    // Menghapus negara dari favorit
    public function destroy($id)
    {
        $favorit = Favorit::where('user_id', Auth::id())
            ->findOrFail($id);

        $favorit->delete();

        return back()->with('success', 'Negara berhasil dihapus dari daftar favorit.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Negara;
use App\Models\DataPelabuhan;
use App\Models\DataBerita;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function dashboard()
    {
        // Statistik
        $totalUser = User::count();
        $totalNegara = Negara::count();
        $totalPelabuhan = DataPelabuhan::count();
        $totalBerita = DataBerita::count();

        // Data terbaru
        $users = User::latest()->take(5)->get();

        $pelabuhan = DataPelabuhan::with('negara')
            ->latest()
            ->take(5)
            ->get();

        $berita = DataBerita::with('negara')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard_admin', compact(
            'totalUser',
            'totalNegara',
            'totalPelabuhan',
            'totalBerita',
            'users',
            'pelabuhan',
            'berita'
        ));
    }

    /**
     * Menghapus berita dari dashboard admin
     */
    public function destroyBerita($id)
    {
        $berita = DataBerita::findOrFail($id);
        $berita->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
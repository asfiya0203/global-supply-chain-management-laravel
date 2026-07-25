<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Negara;
use App\Models\DataPelabuhan;
use App\Models\DataBerita;
use App\Models\DataCuaca;
use App\Http\Controllers\UpdateHarianController;

class AdminController extends Controller
{
    protected $updateHarian;

    public function __construct(UpdateHarianController $updateHarian)
    {
        $this->updateHarian = $updateHarian;
    }

    public function dashboard()
    {
        // Auto update di background saat admin buka halaman
        // Halaman tetap langsung muncul, update jalan di belakang
        $sudahUpdate = DataCuaca::whereDate('tanggal_data', today())->exists();

        if (!$sudahUpdate) {
            dispatch(function () {
                app(UpdateHarianController::class)->cekDanUpdate();
            })->afterResponse();
        }

        // Statistik
        $totalUser      = User::count();
        $totalNegara    = Negara::count();
        $totalPelabuhan = DataPelabuhan::count();
        $totalBerita    = DataBerita::count();

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
}
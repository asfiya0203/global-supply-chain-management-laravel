<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Negara;
use App\Models\DataPelabuhan;
use App\Models\DataBerita;
use App\Models\DataCuaca;
use App\Models\DataBencana;
use App\Models\IndikatorEkonomi;
use App\Models\KursMataUang;
use App\Models\SkorRisikoHarian;
use App\Http\Controllers\UpdateHarianController;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role', 'pengguna')
            ->latest()
            ->get();

        $batasWaktu = Carbon::now()->subDay();

        $berita = DataBerita::with('negara')
            ->where('tanggal_publikasi', '>=', $batasWaktu)
            ->orderBy('tanggal_publikasi', 'desc')
            ->get();

        $bencana = DataBencana::with('negara')
            ->where('tanggal_publikasi', '>=', $batasWaktu)
            ->orderBy('tanggal_publikasi', 'desc')
            ->get();

        $updateTerakhir = [
            'skor' => SkorRisikoHarian::max('tanggal'),
            'kurs' => KursMataUang::max('tanggal'),
            'ekonomi' => IndikatorEkonomi::max('tahun'),
            'cuaca' => DataCuaca::max('tanggal_data'),
            'berita' => DataBerita::max('tanggal_publikasi'),
        ];

        return view('dashboard_admin', compact(
            'users',
            'berita',
            'bencana',
            'updateTerakhir'
        ));
    }

    public function halamanPelabuhan()
    {
        $negara = Negara::orderBy('nama_negara')->get();

        $pelabuhan = DataPelabuhan::with('negara')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('dashboard_admin.pelabuhan', compact('negara', 'pelabuhan'));
    }

     public function updateHarian()
        {
            // nanti panggil command update pelabuhan
            // Artisan::call('pelabuhan:update');

            return back()->with('success', 'Data pelabuhan berhasil diperbarui.');
    }

    public function halamanBerita()
    {
        $batasWaktu = Carbon::now()->subDay();
    
        $berita = DataBerita::with('negara')
            ->where('tanggal_publikasi', '>=', $batasWaktu)
            ->orderBy('tanggal_publikasi', 'desc')
            ->get();
    
        $bencana = DataBencana::with('negara')
            ->where('tanggal_publikasi', '>=', $batasWaktu)
            ->orderBy('tanggal_publikasi', 'desc')
            ->get();
    
        return view('dashboard_admin.data-berita', compact('berita', 'bencana'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function showAdmin()
    {
        return view('dashboard_admin');
    }

    public function dashboard()
    {
        $pengguna = User::where('role', 'pengguna')->get();

        return view('dashboard_admin', compact('pengguna'));
    }
}

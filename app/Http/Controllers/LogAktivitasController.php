<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $admin = auth()->user()->admin;
        $rumahSakit = $admin->rumahSakit;

        $logs = $rumahSakit->log()
            ->with('petugas.user')
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.logaktivitaspage', compact('admin', 'logs'));
    }
}

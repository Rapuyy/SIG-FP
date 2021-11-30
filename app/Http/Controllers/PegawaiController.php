<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = DB::table('pegawai')->paginate(10);

        return view('index', ['pegawai' => $pegawai]);
    }

    public function cari(Request $request)
    {
        $cari = $request->cari;

        $pegawai = DB::table('pegawai')
        ->where('nama', 'like', "%".$cari."%")
        ->paginate();

        return view('index', ['pegawai' => $pegawai]);
    }
}


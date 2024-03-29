<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // KASI
    public function index_kasi()
    {
        return view('user.simoja.kasi.absensi.index');
    }


    // KOORDINATOR
    public function tim_index_koordinator()
    {
        return view('user.simoja.koordinator.absensi.tim_index');
    }
    public function my_index_koordinator()
    {
        return view('user.simoja.koordinator.absensi.my_index');
    }

    public function create_koordinator()
    {
        return view('user.simoja.koordinator.absensi.create');
    }

    // PJLP
    public function my_index_pjlp()
    {
        return view('user.simoja.pjlp.absensi.my_index');
    }

    public function create_pjlp()
    {
        return view('user.simoja.pjlp.absensi.create');
    }
}

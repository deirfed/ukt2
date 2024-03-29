<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    // KASI
    public function index()
    {
        return view('user.simoja.kasi.cuti.index');
    }

    // KOORDINATOR
    public function tim_index_koordinator()
    {
        return view('user.simoja.koordinator.cuti.tim_index');
    }
    public function my_index_koordinator()
    {
        return view('user.simoja.koordinator.cuti.my_index');
    }

    public function create_koordinator()
    {
        return view('user.simoja.koordinator.cuti.create');
    }

    // PJLP
    public function my_index_pjlp()
    {
        return view('user.simoja.pjlp.cuti.my_index');
    }

    public function create_pjlp()
    {
        return view('user.simoja.pjlp.cuti.create');
    }

}

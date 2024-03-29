<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KinerjaController extends Controller
{
    // KASI
    public function index()
    {
        return view('user.simoja.kasi.kinerja.index');
    }

    // KOORDINATOR
    public function tim_index_koordinator()
    {
        return view('user.simoja.koordinator.kinerja.tim_index');
    }
    public function my_index_koordinator()
    {
        return view('user.simoja.koordinator.kinerja.my_index');
    }

    public function create_koordinator()
    {
        return view('user.simoja.koordinator.kinerja.create');
    }

    // PJLP
    public function my_index_pjlp()
    {
        return view('user.simoja.pjlp.kinerja.my_index');
    }

    public function create_pjlp()
    {
        return view('user.simoja.pjlp.kinerja.create');
    }
}

<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use App\Models\KonfigurasiCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        return view('pages.cuti.index');
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_cuti = KonfigurasiCuti::whereYear('periode', $this_year)
                                        ->where('user_id', auth()->user()->id)
                                        ->firstOrFail();
        $jenis_cuti = JenisCuti::all();
        return view('pages.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti',
        ]));
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
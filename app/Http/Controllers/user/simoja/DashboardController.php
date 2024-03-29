<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function kasi_index()
    {
        $today = Carbon::now();
        $tanggal = Carbon::parse($today)->isoFormat('dddd, D MMMM Y');

        return view('user.simoja.kasi.index', compact([
            'tanggal'
        ]));
    }

    public function koordinator_index()
    {
        $today = Carbon::now();
        $tanggal = Carbon::parse($today)->isoFormat('dddd, D MMMM Y');

        return view('user.simoja.koordinator.index', compact([
            'tanggal'
        ]));
    }

    public function pjlp_index()
    {
        $today = Carbon::now();
        $tanggal = Carbon::parse($today)->isoFormat('dddd, D MMMM Y');

        return view('user.simoja.pjlp.index', compact([
            'tanggal'
        ]));
    }
}

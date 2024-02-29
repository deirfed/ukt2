<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JenisAbsensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::where('user_id', auth()->user()->id)
            ->orderBy('tanggal', 'DESC')
            ->get();
        return view('pages.absensi.index', compact(['absensi']));
    }

    public function my_index()
    {
        $absensi = Absensi::where('user_id', auth()->user()->id)
            ->orderBy('tanggal', 'DESC')
            ->get();
        return view('pages.absensi.my_index', compact(['absensi']));
    }

    public function create()
    {
        $jenis_absensi = JenisAbsensi::all();
        return view('pages.absensi.create', compact(['jenis_absensi']));
    }

    public function store(Request $request)
    {
        dd($request);
    }

    public function edit(string $uuid)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
    }
}

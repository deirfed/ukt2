<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\KonfigurasiCuti;
use App\Http\Controllers\Controller;

class KonfigurasiCutiController extends Controller
{
    public function index()
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_cuti = KonfigurasiCuti::where('periode', $this_year)->get();

        return view('superadmin.cuti.konfigurasicuti.index', compact(['konfigurasi_cuti', 'this_year']));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $user = User::all();
        $jenis_cuti = JenisCuti::all();

        return view('superadmin.cuti.konfigurasicuti.create', compact([
            'this_year',
            'user',
            'jenis_cuti',
        ]));
    }

    public function store(Request $request)
    {
        KonfigurasiCuti::create([
            'user_id' => $request->user_id,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'periode' => $request->periode,
            'jumlah' => $request->jumlah,
        ]);
        return redirect()->route('admin-konfigurasi_cuti.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit(string $uuid)
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_cuti = KonfigurasiCuti::where('uuid', $uuid)->firstOrFail();

        $user = User::all();
        $jenis_cuti = JenisCuti::all();

        return view('superadmin.cuti.konfigurasicuti.edit', compact([
            'konfigurasi_cuti',
            'this_year',
            'user',
            'jenis_cuti',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $konfigurasi_cuti = KonfigurasiCuti::where('uuid', $uuid)->firstOrFail();

        $konfigurasi_cuti->update([
            'user_id' => $request->user_id,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'periode' => $request->periode,
            'jumlah' => $request->jumlah,
        ]);
        return redirect()->route('admin-konfigurasi_cuti.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $konfigurasi_cuti = KonfigurasiCuti::findOrFail($request->id);

        $konfigurasi_cuti->delete();

        return redirect()->route('admin-konfigurasi_cuti.index')->withNotify('Data berhasil dihapus!');
    }
}

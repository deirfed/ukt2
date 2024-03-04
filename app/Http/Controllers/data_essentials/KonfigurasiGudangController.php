<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\KonfigurasiCuti;
use App\Models\KonfigurasiGudang;
use App\Http\Controllers\Controller;

class KonfigurasiGudangController extends Controller
{
    public function index()
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_gudang = KonfigurasiGudang::where('periode', $this_year)->get();

        return view('admin.masterdata.data_relasi.relasi_konfigurasi_gudang.index', compact(['konfigurasi_gudang', 'this_year']));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $gudang = Gudang::all();
        $pulau = Pulau::all();
        $seksi = Seksi::all();

        return view('admin.masterdata.data_relasi.relasi_konfigurasi_gudang.create', compact([
            'this_year',
            'gudang',
            'pulau',
            'seksi',
        ]));
    }

    public function store(Request $request)
    {
        KonfigurasiGudang::create([
            'gudang_id' => $request->gudang_id,
            'pulau_id' => $request->pulau_id,
            'seksi_id' => $request->seksi_id,
            'periode' => $request->periode,
        ]);
        return redirect()->route('konfigurasi_gudang.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit(string $uuid)
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_gudang = KonfigurasiGudang::where('uuid', $uuid)->firstOrFail();

        $gudang = Gudang::all();
        $pulau = Pulau::all();
        $seksi = Seksi::all();

        return view('admin.masterdata.data_relasi.relasi_konfigurasi_gudang.edit', compact([
            'konfigurasi_gudang',
            'this_year',
            'gudang',
            'pulau',
            'seksi',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $konfigurasi_gudang = KonfigurasiGudang::where('uuid', $uuid)->firstOrFail();

        $konfigurasi_gudang->update([
            'gudang_id' => $request->gudang_id,
            'pulau_id' => $request->pulau_id,
            'seksi_id' => $request->seksi_id,
            'periode' => $request->periode,
        ]);
        return redirect()->route('konfigurasi_gudang.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $konfigurasi_cuti = KonfigurasiCuti::findOrFail($request->id);
        $konfigurasi_cuti->delete();
        return redirect()->route('konfigurasi_cuti.index')->withNotify('Data berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Seksi;
use App\Models\Struktur;
use App\Models\Tim;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class StrukturController extends Controller
{
    public function index()
    {
        $struktur = Struktur::orderBy('unitkerja_id', 'ASC')
                        ->orderBy('seksi_id', 'ASC')
                        ->orderBy('tim_id', 'ASC')
                        ->get();
        return view('admin.masterdata.data_relasi.relasi_struktur.index', compact(['struktur']));
    }

    public function create()
    {
        $unitkerja = UnitKerja::all();
        $seksi = Seksi::all();
        $tim = Tim::all();

        return view('admin.masterdata.data_relasi.relasi_struktur.create', compact([
            'unitkerja',
            'seksi',
            'tim',
        ]));
    }

    public function store(Request $request)
    {
        Struktur::create([
            'unitkerja_id' => $request->unitkerja_id,
            'seksi_id' => $request->seksi_id,
            'tim_id' => $request->tim_id,
        ]);
        return redirect()->route('struktur.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $struktur = Struktur::where('uuid', $uuid)->first();

        if(!$struktur)
        {
            return back()->withNotifyerror('Something went wrong!');
        }

        $unitkerja = UnitKerja::all();
        $seksi = Seksi::all();
        $tim = Tim::all();

        return view('admin.masterdata.data_relasi.relasi_struktur.edit', compact([
            'struktur',
            'unitkerja',
            'seksi',
            'tim',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $struktur = Struktur::where('uuid', $uuid)->first();

        if(!$struktur)
        {
            return back()->withNotifyerror('Something went wrong!');
        }

        $struktur->update([
            'unitkerja_id' => $request->unitkerja_id,
            'seksi_id' => $request->seksi_id,
            'tim_id' => $request->tim_id,
        ]);

        return redirect()->route('struktur.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $struktur = Struktur::findOrFail($request->id);
        $struktur->delete();
        return redirect()->route('struktur.index')->withNotify('Data berhasil dihapus!');
    }
}
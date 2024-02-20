<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Seksi;
use App\Models\Provinsi;
use App\Models\Walikota;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeksiController extends Controller
{
    public function index()
    {
        $seksi = Seksi::orderBy('name')->get();

        return view('admin.masterdata.data_essentials.seksi.index', compact(['seksi']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.seksi.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Seksi::create($validatedData);

        return redirect()->route('seksi.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $walikota = Walikota::all();
        $provinsi = Provinsi::all();
        $unitkerja = UnitKerja::all();
        $seksi = Seksi::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.seksi.edit', compact(['seksi', 'walikota', 'provinsi', 'unitkerja']));
    }

    public function update(Request $request, $id)
    {
        $unitkerja = Seksi::findOrFail($id);

        $unitkerja->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('seksi.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $seksi = Seksi::findOrFail($id);

        if (!$seksi) {
            return redirect()->back();
        }
        $seksi->delete();

        return redirect()->route('seksi.index')->withNotify('Data berhasil dihapus!');
    }
}

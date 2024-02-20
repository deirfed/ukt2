<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Provinsi;
use App\Models\Walikota;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitkerja = UnitKerja::orderBy('name')->get();

        return view('admin.masterdata.data_essentials.unitkerja.index', compact(['unitkerja']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.unitkerja.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        UnitKerja::create($validatedData);

        return redirect()->route('unitkerja.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $unitkerja = UnitKerja::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.unitkerja.edit', compact(['unitkerja']));
    }

    public function update(Request $request, $id)
    {
        $unitkerja = UnitKerja::findOrFail($id);

        $unitkerja->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('unitkerja.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $unitkerja = UnitKerja::findOrFail($id);

        if (!$unitkerja) {
            return redirect()->back();
        }
        $unitkerja->delete();

        return redirect()->route('unitkerja.index')->withNotify('Data berhasil dihapus!');
    }
}

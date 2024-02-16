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
        $unitkerja = UnitKerja::all();

        return view('admin.masterdata.data_essentials.unitkerja.index', compact(['unitkerja']));
    }

    public function create()
    {
        $walikota = Walikota::all();
        $provinsi = Provinsi::all();
        return view('admin.masterdata.data_essentials.unitkerja.create', compact(['walikota', 'provinsi']));
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'walikota_id' => 'required',
            'provinsi_id' => 'required',
            'admin_id' => 'required',
        ]);

        UnitKerja::create($validatedData);

        return redirect()->route('unitkerja.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $walikota = Walikota::all();
        $provinsi = Provinsi::all();
        $unitkerja = UnitKerja::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.unitkerja.edit', compact(['unitkerja', 'walikota', 'provinsi']));
    }

    public function update(Request $request, $id)
    {
        $unitkerja = UnitKerja::findOrFail($id);

        $unitkerja->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'walikota_id' => $request->input('walikota_id'),
            'provinsi_id' => $request->input('provinsi_id'),
            'admin_id' => $request->input('admin_id'),
        ]);

        return redirect()->route('unitkerja.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $provinsi = UnitKerja::findOrFail($request->id);

        if ($provinsi->canBeDeleted()) {
            $provinsi->delete();

            return redirect()->route('unitkerja.index')->withNotify('Unit Kerja berhasil dihapus!');
        } else {
            return redirect()->route('unitkerja.index')->withError('Unit Kerja tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}

<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Walikota;

class WalikotaController extends Controller
{
    public function index()
    {
        $walikota = Walikota::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.walikota.index', compact(['walikota']));
    }

    public function create()
    {
        $provinsi = Provinsi::all();
        return view('admin.masterdata.data_essentials.walikota.create', compact(['provinsi']));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validateData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'provinsi_id' => 'required',
            'admin_id' => 'required',
        ]);

        Walikota::create($validateData);

        return redirect()->route('walikota.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $provinsi = Provinsi::all();
        $walikota = Walikota::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.walikota.edit', compact(['walikota', 'provinsi']));
    }

    public function update(Request $request, $id)
    {
        $walikota = Walikota::findOrFail($id);

        $walikota->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'provinsi_id' => $request->input('provinsi_id'),
            'admin_id' => $request->input('admin_id'),
        ]);

        return redirect()->route('walikota.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $walikota = Walikota::findOrFail($request->id);

        if ($walikota->canBeDeleted()) {
            $walikota->delete();

            return redirect()->route('walikota.index')->withNotify('Data berhasil dihapus!');
        } else {
            return redirect()->route('walikota.index')->withError('Data tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}

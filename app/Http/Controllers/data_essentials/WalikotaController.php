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
        return view('admin.masterdata.data_essentials.walikota.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validateData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Walikota::create($validateData);

        return redirect()->route('walikota.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $walikota = Walikota::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.walikota.edit', compact(['walikota']));
    }

    public function update(Request $request, $id)
    {
        $walikota = Walikota::findOrFail($id);

        $walikota->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('walikota.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $walikota = Walikota::findOrFail($id);

        if (!$walikota) {
            return redirect()->back();
        }
        $walikota->delete();

        return redirect()->route('walikota.index')->withNotify('Data berhasil dihapus!');
    }
}

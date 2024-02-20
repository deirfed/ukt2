<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvinsiController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.provinsi.index', compact(['provinsi']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.provinsi.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Provinsi::create($validatedData);

        return redirect()->route('provinsi.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $provinsi = Provinsi::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.provinsi.edit', compact(['provinsi']));
    }

    public function update(Request $request, $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        $provinsi->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('provinsi.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $provinsi = Provinsi::findOrFail($id);

        if (!$provinsi) {
            return redirect()->back();
        }
        $provinsi->delete();

        return redirect()->route('provinsi.index')->withNotify('Data berhasil dihapus!');
    }
}

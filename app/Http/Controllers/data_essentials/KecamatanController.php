<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.kecamatan.index', compact(['kecamatan']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.kecamatan.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Kecamatan::create($validatedData);

        return redirect()->route('kecamatan.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $kecamatan = Kecamatan::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.kecamatan.edit', compact(['kecamatan']));
    }

    public function update(Request $request, $id)
    {
        $kecamatan = Kecamatan::findOrFail($id);

        $kecamatan->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('kecamatan.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kecamatan = Kecamatan::findOrFail($id);

        if (!$kecamatan) {
            return redirect()->back();
        }
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')->withNotify('Data berhasil dihapus!');
    }
}

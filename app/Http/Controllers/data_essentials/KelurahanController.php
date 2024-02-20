<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Provinsi;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelurahanController extends Controller
{
    public function index()
    {
        $kelurahan = Kelurahan::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.kelurahan.index', compact(['kelurahan']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.kelurahan.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Kelurahan::create($validatedData);

        return redirect()->route('kelurahan.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $kelurahan = Kelurahan::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.kelurahan.edit', compact(['kelurahan']));
    }

    public function update(Request $request, $id)
    {
        $kelurahan = Kelurahan::findOrFail($id);

        $kelurahan->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('kelurahan.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kelurahan = Kelurahan::findOrFail($id);

        if (!$kelurahan) {
            return redirect()->back();
        }
        $kelurahan->delete();

        return redirect()->route('kelurahan.index')->withNotify('Data berhasil dihapus!');
    }
}


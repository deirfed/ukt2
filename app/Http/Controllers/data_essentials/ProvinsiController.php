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
            'address' => 'required',
            'admin_id' => 'required',
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
            'address' => $request->input('address'),
            'admin_id' => $request->input('admin_id'),
        ]);

        return redirect()->route('provinsi.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $provinsi = Provinsi::findOrFail($request->id);

        if ($provinsi->canBeDeleted()) {
            $provinsi->delete();

            return redirect()->route('provinsi.index')->withNotify('Data berhasil dihapus!');
        } else {
            return redirect()->route('provinsi.index')->withError('Data tidak dapat dihapus karena masih terkait dengan data lain!');
        }
    }
}

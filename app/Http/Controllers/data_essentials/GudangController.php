<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Gudang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.gudang.index', compact(['gudang']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.gudang.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Gudang::create($validatedData);

        return redirect()->route('gudang.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit($uuid)
    {
        $gudang = Gudang::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.gudang.edit', compact(['gudang']));
    }

    public function update(Request $request, $id)
    {
        $gudang = Gudang::findOrFail($id);

        $gudang->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('gudang.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $gudang = Gudang::findOrFail($id);

        if (!$gudang) {
            return redirect()->back();
        }
        $gudang->delete();

        return redirect()->route('gudang.index')->withNotify('Data berhasil dihapus!');
    }
}

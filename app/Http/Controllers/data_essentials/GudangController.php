<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Gudang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pulau;
use App\Models\Seksi;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.gudang.index', compact(['gudang']));
    }

    public function create()
    {
        $pulau = Pulau::all();
        return view('admin.masterdata.data_essentials.gudang.create', compact(['pulau']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'pulau_id' => 'required',
            'code' => 'required',
        ]);

        Gudang::create([
            'name' => $request->name,
            'pulau_id' => $request->pulau_id,
            'code' => $request->code,
        ]);

        return redirect()->route('gudang.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit($uuid)
    {
        $gudang = Gudang::where('uuid', $uuid)->firstOrFail();
        $pulau = Pulau::all();

        return view('admin.masterdata.data_essentials.gudang.edit', compact(['gudang', 'pulau']));
    }

    public function update(Request $request, $id)
    {
        $gudang = Gudang::findOrFail($id);

        $gudang->update([
            'name' => $request->name,
            'code' => $request->code,
            'pulau_id' => $request->pulau_id,
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

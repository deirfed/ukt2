<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class KontrakController extends Controller
{
    public function index()
    {
        $kontrak = Kontrak::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.kontrak.index', compact(['kontrak']));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        return view('admin.masterdata.data_essentials.kontrak.create', compact(['this_year']));
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'no_kontrak' => 'required',
            'periode' => 'required',
        ]);

        Kontrak::create($validatedData);

        return redirect()->route('kontrak.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit($uuid)
    {
        $kontrak = Kontrak::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.kontrak.edit', compact(['kontrak']));
    }

    public function update(Request $request, $id)
    {
        $kontrak = Kontrak::findOrFail($id);

        $kontrak->update([
            'name' => $request->input('name'),
            'no_kontrak' => $request->input('no_kontrak'),
            'periode' => $request->input('periode'),
        ]);

        return redirect()->route('kontrak.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kontrak = Kontrak::findOrFail($id);

        if (!$kontrak) {
            return redirect()->back();
        }
        $kontrak->delete();

        return redirect()->route('kontrak.index')->withNotify('Data berhasil dihapus!');
    }
}

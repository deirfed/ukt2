<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Pulau;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PulauController extends Controller
{
    public function index()
    {
        $pulau = Pulau::orderBy('name')->get();
        return view('admin.masterdata.data_essentials.pulau.index', compact(['pulau']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.pulau.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Pulau::create($validatedData);

        return redirect()->route('pulau.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $pulau = Pulau::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.pulau.edit', compact(['pulau']));
    }

    public function update(Request $request, $id)
    {
        $pulau = Pulau::findOrFail($id);

        $pulau->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('pulau.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $pulau = Pulau::findOrFail($id);

        if (!$pulau) {
            return redirect()->back();
        }
        $pulau->delete();

        return redirect()->route('pulau.index')->withNotify('Data berhasil dihapus!');
    }
}

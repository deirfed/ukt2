<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use Illuminate\Http\Request;

class JenisCutiController extends Controller
{
    public function index()
    {
        $jenis_cuti = JenisCuti::all();

        return view('admin.masterdata.data_essentials.jenis_cuti.index', compact(['jenis_cuti']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.jenis_cuti.create');
    }

    public function store(Request $request)
    {
        JenisCuti::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('jenis_cuti.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit(string $uuid)
    {
        $jenis_cuti = JenisCuti::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.jenis_cuti.edit', compact(['jenis_cuti']));
    }

    public function update(Request $request, string $uuid)
    {
        $jenis_cuti = JenisCuti::where('uuid', $uuid)->firstOrFail();

        $jenis_cuti->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('jenis_cuti.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $jenis_cuti = JenisCuti::findOrFail($id);

        $jenis_cuti->delete();

        return redirect()->route('jenis_cuti.index')->withNotify('Data berhasil dihapus!');
    }
}

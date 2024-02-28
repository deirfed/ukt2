<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\JenisAbsensi;
use Illuminate\Http\Request;

class JenisAbsensiController extends Controller
{
    public function index()
    {
        $jenis_absensi = JenisAbsensi::all();

        return view('admin.masterdata.data_essentials.jenis_absensi.index', compact(['jenis_absensi']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.jenis_absensi.create');
    }

    public function store(Request $request)
    {
        JenisAbsensi::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('jenis_absensi.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit(string $uuid)
    {
        $jenis_absensi = JenisAbsensi::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.jenis_absensi.edit', compact(['jenis_absensi']));
    }

    public function update(Request $request, string $uuid)
    {
        $jenis_absensi = JenisAbsensi::where('uuid', $uuid)->firstOrFail();

        $jenis_absensi->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        return redirect()->route('jenis_absensi.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $jenis_absensi = JenisAbsensi::findOrFail($id);

        $jenis_absensi->delete();

        return redirect()->route('jenis_absensi.index')->withNotify('Data berhasil dihapus!');
    }
}

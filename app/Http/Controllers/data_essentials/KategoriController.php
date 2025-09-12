<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Seksi;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();

        return view('admin.masterdata.data_essentials.kategori.index', compact(['kategori']));
    }

    public function create()
    {
        $seksi = Seksi::all();
        return view('admin.masterdata.data_essentials.kategori.create', compact(['seksi']));
    }

    public function store(Request $request)
    {
        Kategori::create([
            'name' => $request->name,
            'seksi_id' => $request->seksi_id,
        ]);
        return redirect()->route('kategori.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $kategori = Kategori::where('uuid', $uuid)->firstOrFail();
        $seksi = Seksi::all();

        return view('admin.masterdata.data_essentials.kategori.edit', compact(['seksi', 'kategori']));
    }

    public function update(Request $request, string $uuid)
    {
        $kategori = Kategori::where('uuid', $uuid)->firstOrFail();

        $kategori->update([
            'name' => $request->name,
            'seksi_id' => $request->seksi_id,
        ]);

        return redirect()->route('kategori.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kategori = Kategori::findOrFail($id);

        if (! $kategori->cekRelasi()) {
            return redirect()->back()
                ->withError('Kategori masih memiliki data Kinerja, tidak bisa dihapus!');
        }

        $kategori->delete();

        return redirect()->route('admin-kategori.index')
            ->withNotify('Data berhasil dihapus!');
    }
}
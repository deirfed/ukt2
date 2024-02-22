<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::orderBy('name', 'ASC')->get();
        return view('admin.masterdata.data_essentials.jabatan.index', compact(['jabatan']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.jabatan.create');
    }

    public function store(Request $request)
    {
        Jabatan::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('jabatan.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $uuid)
    {
        $jabatan = Jabatan::where('uuid', $uuid)->first();
        if(!$jabatan)
        {
            return back()->withNotifyerror('Something went wrong!');
        }
        return view('admin.masterdata.data_essentials.jabatan.edit', compact(['jabatan']));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('jabatan.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $jabatan = Jabatan::findOrFail($request->id);
        $jabatan->delete();
        return redirect()->route('jabatan.index')->withNotify('Data berhasil dihapus!');
    }
}

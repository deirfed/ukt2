<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Tim;
use Illuminate\Http\Request;

class TimController extends Controller
{
    public function index()
    {
        $tim = Tim::orderBy('name', 'ASC')->get();
        return view('admin.masterdata.data_essentials.tim.index', compact(['tim']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.tim.create');
    }

    public function store(Request $request)
    {
        Tim::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('tim.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $uuid)
    {
        $tim = Tim::where('uuid', $uuid)->first();
        if(!$tim)
        {
            return back()->withNotifyerror('Something went wrong!');
        }
        return view('admin.masterdata.data_essentials.tim.edit', compact(['tim']));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $tim = Tim::findOrFail($id);
        $tim->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);
        return redirect()->route('tim.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $tim = Tim::findOrFail($request->id);
        $tim->delete();
        return redirect()->route('tim.index')->withNotify('Data berhasil dihapus!');
    }
}

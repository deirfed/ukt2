<?php

namespace App\Http\Controllers\data_essentials;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        return view('admin.masterdata.data_essentials.role.index', compact(['role']));
    }

    public function create()
    {
        return view('admin.masterdata.data_essentials.role.create');
    }

    public function store(Request $request)
    {
        // dd($request)
        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        Role::create($validatedData);

        return redirect()->route('role.index')->withNotify('Data berhasil ditambah!');
    }

    public function show($uuid)
    {
        $role = Role::where('uuid', $uuid)->firstOrFail();

        return view('admin.masterdata.data_essentials.role.edit', compact(['role']));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
        ]);

        return redirect()->route('role.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::findOrFail($id);

        if (!$role) {
            return redirect()->back();
        }
        $role->delete();

        return redirect()->route('role.index')->withNotify('Data berhasil dihapus!');
    }
}
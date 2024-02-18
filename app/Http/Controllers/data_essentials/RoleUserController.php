<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        $role_user = RoleUser::orderBy('user_id', 'ASC')->get();
        return view('admin.masterdata.data_essentials.relasi_role_user.index', compact(['role_user']));
    }

    public function create()
    {
        $user = User::orderBy('name', 'ASC')->get();
        $role = Role::all();
        return view('admin.masterdata.data_essentials.relasi_role_user.create', compact([
            'user',
            'role',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' =>'required'
        ]);

        RoleUser::create([
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('role_user.index')->withNotify('Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $role_user = RoleUser::where('uuid', $uuid)->first();
        if(!$role_user)
        {
            return back()->withNotifyerror('Data tidak ditemukan.');
        }
        $role = Role::all();
        return view('admin.masterdata.data_essentials.relasi_role_user.edit', compact([
            'role_user',
            'role',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $role_user = RoleUser::where('uuid', $uuid)->first();
        if(!$role_user)
        {
            return back()->withNotifyerror('Data tidak ditemukan.');
        }

        $role_user->update([
            'role_id' => $request->role_id,
        ]);
        return redirect()->route('role_user.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(string $id)
    {

    }
}
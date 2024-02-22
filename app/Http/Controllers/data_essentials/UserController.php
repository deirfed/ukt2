<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\EmployeeType;
use App\Models\Jabatan;
use App\Models\Role;
use App\Models\Struktur;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users_organik = User::all();
        $users_vendor = User::all();
        return view('admin.masterdata.data_essentials.user.index', compact([
            'users_organik',
            'users_vendor',
        ]));
    }

    public function create()
    {
        $role = Role::all();
        $jabatan = Jabatan::all();
        $employee_type = EmployeeType::all();
        $struktur = Struktur::all();
        $area = Area::all();
        return view('admin.masterdata.data_essentials.user.create', compact([
            'role',
            'jabatan',
            'employee_type',
            'struktur',
            'area',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'phone' => 'required|numeric',
        ]);

        dd($request);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function user_profile()
    {
        return view('pages.profile.index');
    }
}
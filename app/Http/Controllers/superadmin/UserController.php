<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Area;
use App\Models\Role;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\RoleUser;
use App\Models\Struktur;
use App\Models\EmployeeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $employee_type_id = $request->employee_type_id;
        switch ($employee_type_id) {
            case 1:
                $users = User::where('employee_type_id', 1)->get();
                break;
            case 2:
                $users = User::where('employee_type_id', 2)->get();
                break;
            case 3:
                $users = User::where('employee_type_id', 3)->get();
                break;
            default:
                $users = User::all();
                break;
        }

        return view('superadmin.masterdata.user.index', compact([
            'users',
        ]));
    }

    public function create()
    {
        $role = Role::all();
        $jabatan = Jabatan::all();
        $employee_type = EmployeeType::all();
        $struktur = Struktur::all();
        $area = Area::all();
        return view('superadmin.masterdata.user.create', compact([
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

        $password = $password = Hash::make('user123');

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $password,
            "nip" => $request->nip,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "tempat_lahir" => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "alamat" => $request->alamat,
            "role_id" => $request->role_id,
            "jabatan_id" => $request->jabatan_id,
            "employee_type_id" => $request->employee_type_id,
            "area_id" => $request->area_id,
            "struktur_id" => $request->struktur_id,
        ]);

        RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $user->role_id,
        ]);

        return redirect()->route('admin-user.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return back()->withNotifyerror('Data tidak ditemukan');
        }
        $role = Role::all();
        $jabatan = Jabatan::all();
        $employee_type = EmployeeType::all();
        $struktur = Struktur::all();
        $area = Area::all();
        return view('superadmin.masterdata.user.edit', compact([
            'user',
            'role',
            'jabatan',
            'employee_type',
            'struktur',
            'area',
        ]));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'phone' => 'required|numeric',
        ]);

        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "nip" => $request->nip,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "tempat_lahir" => $request->tempat_lahir,
            "tanggal_lahir" => $request->tanggal_lahir,
            "alamat" => $request->alamat,
            "role_id" => $request->role_id,
            "jabatan_id" => $request->jabatan_id,
            "employee_type_id" => $request->employee_type_id,
            "area_id" => $request->area_id,
            "struktur_id" => $request->struktur_id,
        ]);
        return redirect()->route('admin-user.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        return back()->withError('Data tidak bisa dihapus');
    }
}

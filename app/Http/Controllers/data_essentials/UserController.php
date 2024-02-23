<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\EmployeeType;
use App\Models\Jabatan;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Struktur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $employee_type_id = $request->employee_type_id;
        switch($employee_type_id){
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

        return view('admin.masterdata.data_essentials.user.index', compact([
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

        return redirect()->route('user.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if(!$user)
        {
            return back()->withNotifyerror('Data tidak ditemukan');
        }
        $role = Role::all();
        $jabatan = Jabatan::all();
        $employee_type = EmployeeType::all();
        $struktur = Struktur::all();
        $area = Area::all();
        return view('admin.masterdata.data_essentials.user.edit', compact([
            'user',
            'role',
            'jabatan',
            'employee_type',
            'struktur',
            'area',
        ]));
    }

    public function edit(string $id)
    {
        //
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
        return redirect()->route('user.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        return back()->withNotifyerror('Data tidak bisa dihapus');
    }

    public function user_profile()
    {
        return view('pages.profile.index');
    }
}
<?php

namespace App\Http\Controllers\superadmin;

use App\DataTables\UserDataTable;
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
    public function index(UserDataTable $dataTable, Request $request)
    {
        $employee_type_id = $request->employee_type_id;

        return $dataTable->with([
            'employee_type_id' => $employee_type_id,
        ])->render('superadmin.masterdata.user.index');
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
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:role,id',
            'phone' => 'required|numeric',
        ]);

        $defaultPassword = 'user123';

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($defaultPassword),
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

        RoleUser::updateOrCreate([
            'user_id' => $user->id,
            'role_id' => $user->role_id,
        ], [
            'user_id' => $user->id,
            'role_id' => $user->role_id,
        ]);

        return redirect()->route('admin-user.index')->withNotify('Data user <strong>' . $user->name . '</strong> berhasil ditambahkan, dengan default password <strong><code>' . $defaultPassword . '</code></strong>');
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

    public function banOrUnban($uuid) {
        $user = User::where('uuid', $uuid)->firstOrFail();

        //Cek status user sedang banned atau tidak
        if ($user->isBanned()) {
            $user->unban();
            $message = 'unban!';
        } else {
            // Kalau user masih aktif → lakukan Ban
            $user->ban();
            $message = 'banned!';
        }

        return redirect()->route('admin-user.index')->withNotify('User ' . $user->name . ' berhasil di-' . $message);
    }

    public function resetPassword($uuid) {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $defaultPassword = "user123";
        $password = Hash::make($defaultPassword);
        $user->update([
            'password' => $password,
        ]);

        return redirect()->route('admin-user.index')->withNotify("Password user <strong>" . $user->name . "</strong> berhasil diubah ke <strong><code>" . $defaultPassword . "</code></strong>");
    }

    public function destroy(Request $request)
    {
        return back()->withError('Data tidak bisa dihapus');
    }
}

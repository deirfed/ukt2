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
        $rawData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required|exists:role,id',
            'phone' => 'required|numeric',
            "nip" => 'required|string',
            "gender" => 'required|string',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|date',
            "alamat" => 'required|string',
            "jabatan_id" => 'required|exists:jabatan,id',
            "employee_type_id" => 'required|exists:employee_type,id',
            "area_id" => 'required|exists:area,id',
            "struktur_id" => 'required|exists:struktur,id',
        ]);

        $defaultPassword = 'user123';

        $rawData['password'] = Hash::make($defaultPassword);

        $user = User::updateOrCreate($rawData, $rawData);

        RoleUser::updateOrCreate([
            'user_id' => $user->id,
            'role_id' => $user->role_id,
        ], [
            'user_id' => $user->id,
            'role_id' => $user->role_id,
        ]);

        $message = 'Data user <strong>' . $user->name . '</strong> berhasil ditambahkan, dengan default password <strong><code>' . $defaultPassword . '</code></strong>';
        if($user->employee_type_id == 3) {
            $message = 'Data user <strong>' . $user->name . '</strong> berhasil ditambahkan, dengan default password <strong><code>' . $defaultPassword . '</code></strong>, segera lakukan setting <strong>Formasi Tim & Konfigurasi Cuti</strong> agar user bisa login!';
        }

        return redirect()->route('admin-user.index')->withNotify($message);
    }

    public function show(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
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

        $rawData = $request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,{$user->id}",
            'role_id' => 'required|exists:role,id',
            'phone' => 'required|numeric',
            "nip" => 'required|string',
            "gender" => 'required|string',
            "tempat_lahir" => 'required|string',
            "tanggal_lahir" => 'required|date',
            "alamat" => 'required|string',
            "jabatan_id" => 'required|exists:jabatan,id',
            "employee_type_id" => 'required|exists:employee_type,id',
            "area_id" => 'required|exists:area,id',
            "struktur_id" => 'required|exists:struktur,id',
        ]);

        $user->update($rawData);

        return redirect()->route('admin-user.index')->withNotify('Data user <strong>' . $user->name . '</strong> berhasil diperbaharui!');
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

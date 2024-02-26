<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\EmployeeType;
use App\Models\FormasiTim;
use App\Models\Jabatan;
use App\Models\JenisCuti;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KonfigurasiCuti;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\UnitKerja;
use App\Models\Walikota;
use App\Models\Seksi;
use App\Models\Pulau;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Struktur;
use App\Models\Tim;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function data_essentials()
    {
        $provinsi = Provinsi::count();
        $walikota = Walikota::count();
        $unitkerja = UnitKerja::count();
        $seksi = Seksi::count();
        $kelurahan = Kelurahan::count();
        $kecamatan = Kecamatan::count();
        $pulau = Pulau::count();
        $role = Role::count();
        $users = User::count();
        $jabatan = Jabatan::count();
        $employee_type = EmployeeType::count();
        $tim = Tim::count();
        $kategori = Kategori::count();
        $jenis_cuti = JenisCuti::count();
        return view('admin.masterdata.data_essentials.index', compact([
            'provinsi',
            'walikota',
            'unitkerja',
            'seksi',
            'kelurahan',
            'kecamatan',
            'pulau',
            'role',
            'jabatan',
            'employee_type',
            'tim',
            'kategori',
            'jenis_cuti',
            'users',
        ]));
    }

    public function data_assets()
    {
        return view('admin.masterdata.data_assets.index');
    }

    public function data_relasi()
    {
        $role_user = RoleUser::count();
        $area = Area::count();
        $struktur = Struktur::count();
        $formasi_tim = FormasiTim::count();
        $konfigurasi_cuti = KonfigurasiCuti::count();
        return view('admin.masterdata.data_relasi.index', compact([
            'role_user',
            'area',
            'struktur',
            'formasi_tim',
            'konfigurasi_cuti',
        ]));
    }

    public function pulau()
    {
        return view('admin.masterdata.data_assets.pulau.index');
    }

}
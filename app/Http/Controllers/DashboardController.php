<?php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\Area;
use App\Models\Cuti;
use App\Models\Role;
use App\Models\User;
use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\Gudang;
use App\Models\Jabatan;
use App\Models\Kinerja;
use App\Models\Kontrak;
use App\Models\Kategori;
use App\Models\Provinsi;
use App\Models\RoleUser;
use App\Models\Struktur;
use App\Models\Walikota;
use App\Models\JenisCuti;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UnitKerja;
use App\Models\FormasiTim;
use App\Models\EmployeeType;
use App\Models\JenisAbsensi;
use Illuminate\Support\Carbon;
use App\Models\KonfigurasiCuti;
use App\Models\KonfigurasiAbsensi;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;
use Svg\Tag\Rect;

class DashboardController extends Controller
{
    public function index()
    {
        // Navigasi
        $jabatan_id = auth()->user()->jabatan->id;

        // Dashboard
        $today = Carbon::today();
        $tahun = date('Y');
        $totalUser = User::where('employee_type_id', 3)->count();
        $jumlahKinerja = Kinerja::whereYear('tanggal', now()->year)->count();
        $jumlahKinerja = number_format($jumlahKinerja, 0, ',', '.');

        $cuti = Cuti::whereHas('user', function ($q) {
            $q->where('employee_type_id', 3);
        })
            ->whereDate('tanggal_awal', '<=', $today)
            ->whereDate('tanggal_akhir', '>=', $today)
            ->count();

        $tersedia = $totalUser - $cuti;

        $persentase = $totalUser > 0 ? ($tersedia / $totalUser) * 100 : 0;

        $cutiHariIni = Cuti::where('tanggal_awal', '<=', $today)
            ->where('tanggal_akhir', '>=', $today)
            ->count();

        // Abesensi
        $user_id = null;

        $user = User::where('employee_type_id', 3)
            ->orderBy('name', 'ASC')
            ->get();

        $periode = now()->format('Y-m');
        $kategori = Kategori::get();
        $kategori_id = $request->kategori_id ?? null;

        $start_date = Carbon::createFromFormat('Y-m', $periode)->startOfMonth()->toDateString();
        $end_date   = Carbon::createFromFormat('Y-m', $periode)->endOfMonth()->toDateString();

        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date) ?? $start_date;

        if ($jabatan_id == 1) {
            return redirect()->route('simoja.kasi.index');
        } elseif ($jabatan_id == 2) {
            return redirect()->route('simoja.kasi.index');
        } elseif ($jabatan_id == 3) {
            return redirect()->route('simoja.koordinator.index');
        } elseif ($jabatan_id == 4) {
            return redirect()->route('simoja.koordinator.index');
        } elseif ($jabatan_id == 5) {
            return redirect()->route('simoja.pjlp.index');
        } else {
            return view(
                'superadmin.dashboard.index',
                compact(
                    'totalUser',
                    'jumlahKinerja',
                    'tahun',
                    'tersedia',
                    'persentase',
                    'cutiHariIni',
                    'user',
                    'user_id',
                    'periode',
                    'kategori',
                    'kategori_id',
                    'start_date',
                    'end_date',
                )
            );
        }
    }

    public function godmode()
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
        $jenis_absensi = JenisAbsensi::count();
        $kontrak = Kontrak::count();
        $gudang = Gudang::count();
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
            'jenis_absensi',
            'users',
            'kontrak',
            'gudang',
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
        $konfigurasi_absensi = KonfigurasiAbsensi::count();
        return view('admin.masterdata.data_relasi.index', compact([
            'role_user',
            'area',
            'struktur',
            'formasi_tim',
            'konfigurasi_cuti',
            'konfigurasi_absensi',
        ]));
    }

    public function pulau()
    {
        return view('admin.masterdata.data_assets.pulau.index');
    }

    public function aset_kasie()
    {
        return view('pages.home.aset_kasie');
    }

    public function aset_koordinator()
    {
        return view('pages.home.aset_koordinator');
    }

    public function aset_pjlp()
    {
        return view('pages.home.aset_pjlp');
    }
    public function simoja_kasie()
    {
        return view('pages.home.simoja_kasie');
    }

    public function simoja_koordinator()
    {
        return view('pages.home.simoja_koordinator');
    }

    public function simoja_pjlp()
    {
        return view('pages.home.simoja_pjlp');
    }

    public function landingpage()
    {
        return view('landingpage.index');
    }

    // Superadmin
    public function getUsers()
    {
        $users = User::where('employee_type_id', 3)
            ->orderBy('name', 'asc')
            ->get(['id', 'name']);

        return response()->json($users);
    }
}

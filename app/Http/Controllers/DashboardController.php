<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\UnitKerja;
use App\Models\Walikota;
use App\Models\Seksi;

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
        return view('admin.masterdata.data_essentials.index', compact(['provinsi', 'walikota', 'unitkerja', 'seksi']));
    }

    public function data_assets()
    {
        return view('admin.masterdata.data_assets.index');
    }

    public function pulau()
    {
        return view('admin.masterdata.data_assets.pulau.index');
    }

}

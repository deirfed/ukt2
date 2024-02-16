<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Provinsi;
use App\Models\UnitKerja;
use App\Models\Walikota;

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
        return view('admin.masterdata.data_essentials.index', compact(['provinsi', 'walikota', 'unitkerja']));
    }

    public function data_assets()
    {
        return view('admin.masterdata.data_assets.index');
    }
}

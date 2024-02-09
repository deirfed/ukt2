<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Provinsi;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function data_essentials()
    {
        $provinsi = Provinsi::count();
        return view('admin.masterdata.data_essentials.index', compact(['provinsi']));
    }

    public function data_assets()
    {
        return view('admin.masterdata.data_assets.index');
    }
}

<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeksiController extends Controller
{
    public function index()
    {
        return view('admin.masterdata.data_essentials.unitkerja.index');
    }
}

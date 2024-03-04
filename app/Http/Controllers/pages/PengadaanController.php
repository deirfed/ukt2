<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengadaanController extends Controller
{
    public function index()
    {
        return view('pages.pengadaan.index');
    }

    public function list_data()
    {
        return view('pages.pengadaan.list_data');
    }

    public function create()
    {
        return view('pages.pengadaan.create');
    }
}

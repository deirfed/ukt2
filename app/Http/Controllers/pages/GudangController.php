<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        return view('pages.gudang.index');
    }

    public function creat_distribusi()
    {
        return view ('pages.gudang.distribusi');
    }
}

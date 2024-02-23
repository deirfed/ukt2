<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KinerjaController extends Controller
{
    public function index()
    {
        return view('pages.kinerja.index');
    }

    public function formasi()
    {
        return view('pages.kinerja.formasi');
    }
}

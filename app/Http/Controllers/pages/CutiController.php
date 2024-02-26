<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        return view('pages.cuti.index');
    }

    public function create()
    {
        return view('pages.cuti.create');
    }
}

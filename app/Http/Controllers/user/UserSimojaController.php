<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSimojaController extends Controller
{
    public function kasi_index()
    {
        return view('user.simoja.kasi.index');
    }

    public function koordinator_index()
    {
        return view('user.simoja.koordinator.index');
    }

    public function pjlp_index()
    {
        return view('user.simoja.pjlp.index');
    }
}

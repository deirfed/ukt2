<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAsetController extends Controller
{
    public function kasi_index()
    {
        return view('user.aset.kasi.index');
    }

    public function koordinator_index()
    {
        return view('user.aset.koordinator.index');
    }

    public function pjlp_index()
    {
        return view('user.aset.pjlp.index');
    }
}

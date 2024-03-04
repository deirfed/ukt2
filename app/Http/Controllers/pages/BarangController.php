<?php

namespace App\Http\Controllers\pages;

use App\Models\Barang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('pages.barang.index', compact(['barang']));
    }

    public function create()
    {
        $kontrak = Kontrak::all();

        return view('pages.barang.create', compact(['kontrak']));
    }

    public function store()
    {
    }

    public function edit($uuid)
    {
        $barang = Barang::where('uuid', $uuid)->firstOrFail();

        return view('pages.barang.edit', compact(['barang']));
    }

    public function destroy()
    {
    }

    public function gudang()
    {
        $barang = Barang::all();
        return view('pages.barang.gudang', compact(['barang']));
    }
}

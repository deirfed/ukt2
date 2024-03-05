<?php

namespace App\Http\Controllers\pages;

use App\Models\Barang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KonfigurasiGudang;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        $gudang_tujuan = KonfigurasiGudang::all();
        return view('pages.barang.index', compact(['barang', 'gudang_tujuan']));
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

    public function pengiriman()
    {
        return view('pages.barang.pengiriman');
    }

    public function penerimaan()
    {
        $barang  = Barang::all();
        return view('pages.barang.penerimaan', compact(['barang']));
    }

    public function my_gudang()
    {
        return view('pages.barang.my_gudang');
    }


    public function transaksi()
    {
        return view('pages.barang.transaksi_barang');
    }
}

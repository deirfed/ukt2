<?php

namespace App\Http\Controllers\pages;

use App\Models\Barang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KonfigurasiGudang;
use Faker\Provider\Base;

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

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->update([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'merk' => $request->input('merk'),
            'jenis' => $request->input('jenis'),
            'stock_awal' => $request->input('stock_awal'),
            'stock_aktual' => $request->input('stock_aktual'),
            'satuan' => $request->input('satuan'),
            'harga' => $request->input('harga'),
            'spesifikasi' => $request->input('spesifikasi'),
        ]);

        return redirect()->route('barang.index')->withNotify('Data berhasil diubah!');
    }


    public function destroy()
    {

    }

    public function pengiriman()
    {
        $barang = Barang::all();
        return view('pages.barang.pengiriman', compact(['barang']));
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

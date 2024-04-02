<?php

namespace App\Http\Controllers\user\aset;

use App\Models\Seksi;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class BarangController extends Controller
{
    // KASI
    public function kasi_index()
    {
        $barang = Barang::where('stock_aktual', '>', 0)->get();
        $gudang_tujuan = Gudang::all();

        $kontrak = Kontrak::all();
        $seksi = Seksi::all();
        $tahun = Carbon::now()->format("Y");

        return view('user.aset.kasi.gudang.index', compact([
            'barang',
            'gudang_tujuan',
            'kontrak',
            'seksi',
            'tahun',
        ]));
    }

    public function kasi_create()
    {
        $kontrak = Kontrak::all();
        $kontrak->map(function ($item, $key) {
            $item->periode = Carbon::parse($item->tanggal)->format('Y');
            return $item;
        });

        return view('user.aset.kasi.gudang.create', compact(['kontrak']));
    }

    public function kasi_store(Request $request)
    {
        $request->validate([
            'kontrak_id' => 'required',
            'file' => 'required|file|mimes:xlsx,xls',
        ], [
            'file.mimes' => 'file harus dalam format .xlsx/.xls',
        ]);

        $kontrak_id = $request->kontrak_id;

        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            Excel::import(new BarangImport($kontrak_id), $file);
        }

        return redirect()->route('aset.gudang-utama')->withNotify('Data berhasil di-import!');
    }


    // KOORDINATOR
    public function koordinator_index()
    {
        return view('user.aset.koordinator.gudang.my_gudang');
    }

    public function koordinator_form_pemakaian()
    {
        return view('user.aset.koordinator.gudang.form_pemakaian');
    }

    public function koordinator_histori_transaksi()
    {
        return view('user.aset.koordinator.gudang.my_transaksi');
    }


    // PJLP
    public function pjlp_index()
    {
        return view('user.aset.pjlp.gudang.my_gudang');
    }

    public function pjlp_form_pemakaian()
    {
        return view('user.aset.pjlp.gudang.form_pemakaian');
    }

    public function pjlp_histori_transaksi()
    {
        return view('user.aset.pjlp.gudang.my_transaksi');
    }

}

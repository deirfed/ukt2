<?php

namespace App\Http\Controllers\pages;

use App\Models\Barang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use App\Models\Gudang;
use App\Models\KonfigurasiGudang;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        $gudang_tujuan = Gudang::all();
        return view('pages.barang.index', compact(['barang', 'gudang_tujuan']));
    }

    public function create()
    {
        $kontrak = Kontrak::all();

        return view('pages.barang.create', compact(['kontrak']));
    }

    public function store(Request $request)
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

        return redirect()->route('barang.index')->withNotify('Data berhasil di-import!');
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

        if ($request->hasFile('photo') && $request->photo != '')
        {
            $image = Image::make($request->file('photo'));

            $imageName = time().'-'.$request->file('photo')->getClientOriginalName();
            $detailPath = 'asset/photo_awal/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($destinationPath.$imageName);

            $barang->photo = $detailPath.$imageName;
            $barang->save();
        }

        return redirect()->route('barang.index')->withNotify('Data berhasil diubah!');
    }


    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->id;
        $barang = Barang::findOrFail($id);
        if($barang->photo != null)
        {
            Storage::delete($barang->photo);
        }
        $barang->forceDelete();
        return redirect()->route('barang.index')->withNotify('Data berhasil dihapus!');
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

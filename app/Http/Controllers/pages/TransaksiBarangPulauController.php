<?php

namespace App\Http\Controllers\pages;

use App\Exports\transaksi_barang_pulau\TransaksiBarangPulauExport;
use App\Http\Controllers\Controller;
use App\Models\BarangPulau;
use App\Models\TransaksiBarangPulau;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiBarangPulauController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $transaksi = TransaksiBarangPulau::where('user_id', $user_id)
                    ->orderBy('tanggal', 'DESC')
                    ->get();
        return view('pages.transaksi_barang_pulau.index', compact(['transaksi']));
    }

    public function create(Request $request)
    {
        $barang_pulau_id = $request->barang_pulau_id;

        $barang_pulau = BarangPulau::whereIn('id', $barang_pulau_id)->get();

        return view('pages.barang_pulau.create', compact(['barang_pulau']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo.*' => 'required|image',
            'tanggal' => 'required',
            'barang_pulau_id.*' => 'required',
            'kegiatan' => 'required',
            'qty.*' => 'required|numeric',
        ]);

        $user_id = auth()->user()->id;
        $tanggal = $request->tanggal;
        $barang_pulau_ids = $request->barang_pulau_id;
        $qty = $request->qty;
        $photo = $request->file('photo');
        $kegiatan = $request->kegiatan;
        $catatan = $request->catatan;

        foreach ($barang_pulau_ids as $key => $barang_pulau_id) {
            $image = Image::make($photo[$key]);

            $imageName = time() . '-' . $photo[$key]->getClientOriginalName();
            $detailPath = 'asset/photo_transaksi/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($destinationPath.$imageName);
            $photo_transaksi = $detailPath.$imageName;

            TransaksiBarangPulau::create([
                'user_id' => $user_id,
                'barang_pulau_id' => $barang_pulau_id,
                'qty' => $qty[$key],
                'photo' => $photo_transaksi,
                'tanggal' => $tanggal,
                'kegiatan' => $kegiatan,
                'catatan' => $catatan,
            ]);

            $barang_pulau = BarangPulau::findOrFail($barang_pulau_id);
            $barang_pulau->update([
                'stock_aktual' => $barang_pulau->stock_aktual - $qty[$key],
            ]);
        }

        return redirect()->route('transaksi.barang.index')->withNotify('Data transaksi berhasil disimpan!');
    }

    public function excel()
    {
        $waktu = Carbon::now()->format('Ymd');

        return Excel::download(new TransaksiBarangPulauExport, $waktu . '_data transaksi barang.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

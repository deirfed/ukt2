<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\PengirimanBarang;
use App\Models\Seksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PengirimanBarangController extends Controller
{
    public function index()
    {
        $pengiriman_barang = PengirimanBarang::select('no_resi', 'submitter_id', 'receiver_id', 'gudang_id', 'tanggal_kirim', 'tanggal_terima', 'catatan', 'status')->distinct()->get();
        return view('pages.barang.pengiriman', compact(['pengiriman_barang']));
    }

    public function create(Request $request)
    {
        $request->validate([
            'barang_id' => 'array|required'
        ]);

        $barang_id = $request->barang_id;

        $barang = Barang::whereIn('id', $barang_id)->get();

        $gudang = Gudang::all();
        $seksi = Seksi::all();
        return view('pages.barang.transaksi.kirim_barang', compact([
            'barang',
            'gudang',
            'seksi',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo.*' => 'required|image',
            'submitter_id' => 'required',
            'gudang_id' => 'required',
            'barang_id.*' => 'required',
            'qty.*' => 'required|numeric',
        ]);

        $submitter_id = $request->submitter_id;
        $gudang_id = $request->gudang_id;
        $barang_ids = $request->barang_id;
        $qty = $request->qty;
        $photo = $request->file('photo');
        $catatan = $request->catatan;
        $no_resi = $this->generateNoResi();
        $tanggal_kirim = Carbon::now();

        foreach ($barang_ids as $key => $barang_id) {
            $image = Image::make($photo[$key]);

            $imageName = time() . '-' . $photo[$key]->getClientOriginalName();
            $detailPath = 'asset/photo_pengiriman/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($destinationPath.$imageName);
            $photo_kirim = $detailPath.$imageName;

            PengirimanBarang::create([
                'no_resi' => $no_resi,
                'submitter_id' => $submitter_id,
                'gudang_id' => $gudang_id,
                'barang_id' => $barang_id,
                'qty' => $qty[$key],
                'photo_kirim' => $photo_kirim,
                'tanggal_kirim' => $tanggal_kirim,
                'catatan' => $catatan,
                'status' => 'Dikirim',
            ]);

            $barang = Barang::findOrFail($barang_id);
            $barang->update([
                'stock_aktual' => $barang->stock_aktual - $qty[$key],
            ]);
        }

        return redirect()->route('pengiriman.index')->withNotify('Data pengiriman barang berhasil disimpan');
    }

    public function show($no_resi)
    {
        $pengiriman_barang = PengirimanBarang::where('no_resi', $no_resi)->get();
        $validasi = $pengiriman_barang->where('photo_terima', null)->count();
        return view('pages.barang.transaksi.detail', compact(['pengiriman_barang', 'validasi']));
    }

    public function terima(Request $request)
    {
        $request->validate([
            'photo_terima.*' => 'required|image',
        ]);

        $ids = $request->ids;
        $photo = $request->file('photo_terima');
        $tanggal_terima = Carbon::now();

        foreach ($ids as $key => $id) {
            $image = Image::make($photo[$key]);

            $imageName = time() . '-' . $photo[$key]->getClientOriginalName();
            $detailPath = 'asset/photo_penerimaan/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, 500, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->save($destinationPath.$imageName);
            $photo_terima = $detailPath.$imageName;

            $pengiriman_barang = PengirimanBarang::findOrFail($id);

            $pengiriman_barang->update([
                'receiver_id' => auth()->user()->id,
                'tanggal_terima' => $tanggal_terima,
                'photo_terima' => $photo_terima,
                'status' => 'Diterima',
            ]);
        }

        return redirect()->route('pengiriman.index')->withNotify('Data pengiriman barang berhasil diterima di gudang tujuan');
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function generateNoResi()
    {
        $timestamp = now()->format('YmdHis');
        $randomNumber = mt_rand(1000, 9999);

        $no_resi = $timestamp . $randomNumber;

        return $no_resi;
    }
}

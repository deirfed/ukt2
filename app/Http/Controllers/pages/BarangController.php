<?php

namespace App\Http\Controllers\pages;

use App\Models\Barang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\BarangImport;
use App\Models\Gudang;
use App\Models\KonfigurasiGudang;
use App\Models\Seksi;
use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::where('stock_aktual', '>', 0)->get();
        $gudang_tujuan = Gudang::all();

        $kontrak = Kontrak::all();
        $seksi = Seksi::all();
        $tahun = Carbon::now()->format("Y");

        return view('pages.barang.index', compact([
            'barang',
            'gudang_tujuan',
            'kontrak',
            'seksi',
            'tahun',
        ]));
    }

    public function create()
    {
        $kontrak = Kontrak::all();
        $kontrak->map(function ($item, $key) {
            $item->periode = Carbon::parse($item->tanggal)->format('Y');
            return $item;
        });

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
        $request->validate([
            'photo.*' => 'required|file|image',
            'photo' => 'max:3',
        ], [
            'photo.max' => '*Photo yang dilampirkan maksimal 3.'
        ]);

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

        if ($request->hasFile('photo'))
        {
            if($barang->photo != null)
            {
                foreach(json_decode($barang->photo) as $photo)
                {
                    Storage::delete($photo);
                }
            }

            $lampiranPaths = [];
            $detailPath = 'asset/photo_awal/';
            foreach ($request->file('photo') as $file) {
                $image = Image::make($file);

                $imageName = time().'-'.$file->getClientOriginalName();
                $destinationPath = public_path('storage/'. $detailPath);

                $image->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image->save($destinationPath.$imageName);
                $lampiranPaths[] = $detailPath . $imageName;
            }

            $barang->photo = json_encode($lampiranPaths);
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
            foreach(json_decode($barang->photo) as $photo)
            {
                Storage::delete($photo);
            }
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

    public function filter(Request $request)
    {
        $periode = $request->periode;
        $kontrak_id = $request->kontrak_id;
        $jenis = $request->jenis;
        $seksi_id = $request->seksi_id;

        $barang = Barang::query();

        // Filter by periode
        $barang->when($periode, function ($query) use ($periode) {
            return $query->whereHas('kontrak', function ($query) use ($periode) {
                $query->whereYear('tanggal', $periode);
            });
        });

        // Filter by kontrak_id
        $barang->when($kontrak_id, function ($query) use ($request) {
            return $query->whereRelation('kontrak', 'id', '=', $request->kontrak_id);
        });

        // Filter by jenis
        $barang->when($jenis, function ($query) use ($request) {
            return $query->where('jenis', $request->jenis);
        });

        // Filter by seksi_id
        $barang->when($seksi_id, function ($query) use ($request) {
            return $query->whereRelation('kontrak.seksi', 'id', '=', $request->seksi_id);
        });

        $gudang_tujuan = Gudang::all();

        $kontrak = Kontrak::all();
        $seksi = Seksi::all();
        $tahun = Carbon::now()->format("Y");

        return view('pages.barang.index', [
            'barang' => $barang->orderBy('name', 'ASC')->get(),
            'gudang_tujuan' => $gudang_tujuan,
            'kontrak' => $kontrak,
            'seksi' => $seksi,
            'tahun' => $tahun,
        ]);
    }
}

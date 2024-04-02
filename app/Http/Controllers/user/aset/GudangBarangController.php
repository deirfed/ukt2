<?php

namespace App\Http\Controllers\user\aset;

use App\Models\Seksi;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use App\Imports\BarangImport;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\BarangPulau;
use App\Models\TransaksiBarangPulau;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class GudangBarangController extends Controller
{
    // KASI
    public function kasi_index()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $barang = Barang::where('stock_aktual', '>', 0)
                        ->whereRelation('kontrak.seksi', 'id', '=', $seksi_id)
                        ->orderBy('kontrak_id', 'ASC')
                        ->orderBy('name', 'ASC')
                        ->get();

        $gudang_tujuan = Gudang::all();
        $kontrak = Kontrak::where('seksi_id', $seksi_id)->orderBy('tanggal', 'DESC')->get();
        $seksi = Seksi::all();
        $tahun = Carbon::now()->format('Y');

        return view('user.aset.kasi.gudang.index', compact([
            'barang',
            'gudang_tujuan',
            'kontrak',
            'seksi',
            'tahun'
        ]));
    }

    public function kasi_create()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $kontrak = Kontrak::where('seksi_id', $seksi_id)->orderBy('tanggal', 'DESC')->get();
        $kontrak->map(function ($item, $key) {
            $item->periode = Carbon::parse($item->tanggal)->format('Y');
            return $item;
        });

        return view('user.aset.kasi.gudang.create', compact(['kontrak']));
    }

    public function kasi_store(Request $request)
    {
        $request->validate(
            [
                'kontrak_id' => 'required',
                'file' => 'required|file|mimes:xlsx,xls',
            ],
            [
                'file.mimes' => 'file harus dalam format .xlsx/.xls',
            ],
        );

        $kontrak_id = $request->kontrak_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Excel::import(new BarangImport($kontrak_id), $file);
        }

        return redirect()->route('aset.gudang-utama')->withNotify('Data berhasil di-import!');
    }

    public function kasi_edit($uuid)
    {
        $barang = Barang::where('uuid', $uuid)->firstOrFail();

        return view('user.aset.kasi.gudang.edit', compact(['barang']));
    }

    public function kasi_update(Request $request, $id)
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

        return redirect()->route('aset.gudang-utama')->withNotify('Data berhasil diubah!');
    }

    public function kasi_gudang_pulau()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $barang_pulau = BarangPulau::whereRelation('barang.kontrak.seksi', 'id', '=', $seksi_id)
                        ->orderBy('gudang_id')
                        ->get();
        return view('user.aset.kasi.gudang.gudang_pulau', compact([
            'barang_pulau',
        ]));
    }

    public function kasi_gudang_pulau_trans()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $transaksi = TransaksiBarangPulau::whereRelation('barang_pulau.barang.kontrak.seksi', 'id', '=', $seksi_id)
                    ->orderBy('tanggal', 'DESC')
                    ->get();

        return view('user.aset.kasi.gudang.transaksi_pulau', compact([
            'transaksi'
        ]));
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

    public function koordinator_histori_transaksi_tim()
    {
        return view('user.aset.koordinator.gudang.tim_transaksi');
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

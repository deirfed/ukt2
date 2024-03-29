<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use App\Models\FormasiTim;
use App\Models\Kategori;
use App\Models\Kinerja;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class KinerjaController extends Controller
{
    // KASI
    public function index()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $kinerja = Kinerja::where('seksi_id', $seksi_id)->orderBy('tanggal', 'DESC')->get();
        return view('user.simoja.kasi.kinerja.index', compact([
            'kinerja'
        ]));
    }

    // KOORDINATOR
    public function tim_index_koordinator()
    {
        return view('user.simoja.koordinator.kinerja.tim_index');
    }

    public function my_index_koordinator()
    {
        return view('user.simoja.koordinator.kinerja.my_index');
    }

    public function create_koordinator()
    {
        return view('user.simoja.koordinator.kinerja.create');
    }

    // PJLP
    public function my_index_pjlp()
    {
        $user_id = auth()->user()->id;
        $kinerja = Kinerja::where('anggota_id', $user_id)->get();
        return view('user.simoja.pjlp.kinerja.my_index', compact(['kinerja']));
    }

    public function create_pjlp()
    {
        $user_id = auth()->user()->id;
        $formasi_tim = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail();
        $kategori = Kategori::where('seksi_id', $formasi_tim->struktur->seksi->id)->get();
        return view('user.simoja.pjlp.kinerja.create', compact([
            'formasi_tim',
            'kategori',
        ]));
    }

    public function store_pjlp(Request $request)
    {
        $request->validate([
            'photo.*' => 'required|file|image',
            'photo' => 'max:3',
        ], [
            'photo.max' => '*Photo yang dilampirkan maksimal 3.'
        ]);

        $anggota_id = $request->anggota_id;
        $formasi_tim_id = $request->formasi_tim_id;
        $kategori_id = $request->kategori_id;
        $kegiatan = $request->kegiatan;
        $tanggal = $request->tanggal;
        $lokasi = $request->lokasi;
        $deskripsi = $request->deskripsi;

        $formasi_tim = FormasiTim::findOrFail($formasi_tim_id);

        $kinerja = Kinerja::create([
            'formasi_tim_id' => $formasi_tim->id,
            'unitkerja_id' => $formasi_tim->struktur->unitkerja->id,
            'seksi_id' => $formasi_tim->struktur->seksi->id,
            'tim_id' => $formasi_tim->struktur->tim->id,
            'pulau_id' => $formasi_tim->area->pulau->id,
            'koordinator_id' => $formasi_tim->koordinator->id,
            'anggota_id' => $anggota_id,
            'kategori_id' => $kategori_id,
            'kegiatan' => $kegiatan,
            'tanggal' => $tanggal,
            'lokasi' => $lokasi,
            'deskripsi' => $deskripsi,
        ]);

        if ($request->hasFile('photo')) {
            $kinerja = Kinerja::findOrFail($kinerja->id);

            $lampiranPaths = [];
            $detailPath = 'kinerja/kegiatan/';
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

            $kinerja->photo = json_encode($lampiranPaths);
            $kinerja->save();
        }

        return redirect()->route('simoja.pjlp.my-kinerja')->withNotify('Data Laporan Kinerja berhasil ditambahkan!');
    }
}

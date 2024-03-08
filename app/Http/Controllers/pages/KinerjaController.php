<?php

namespace App\Http\Controllers\pages;

use App\Exports\kinerja\KinerjaExport;
use App\Http\Controllers\Controller;
use App\Models\FormasiTim;
use App\Models\Kategori;
use App\Models\Kinerja;
use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\Tim;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class KinerjaController extends Controller
{
    public function index()
    {
        $kinerja = Kinerja::orderBy('tanggal', 'DESC')->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $seksi  = Seksi::all();
        $koordinator  = User::whereRelation('jabatan', 'id', '=', 4)->get();
        $tim = Tim::orderBy('name', 'ASC')->get();

        $pulau_id = '';
        $seksi_id = '';
        $koordinator_id = '';
        $tim_id = '';
        $start_date = '';
        $end_date = '';
        return view('pages.kinerja.index', compact([
            'kinerja',
            'pulau',
            'seksi',
            'koordinator',
            'tim',
            'pulau_id',
            'seksi_id',
            'koordinator_id',
            'tim_id',
            'start_date',
            'end_date',
        ]));
    }

    public function my_index()
    {
        $user_id = auth()->user()->id;
        $kinerja = Kinerja::where('anggota_id', $user_id)
                        ->orWhere('koordinator_id', $user_id)
                        ->orderBy('tanggal', 'DESC')
                        ->get();
        return view('pages.kinerja.my_index', compact([
            'kinerja',
        ]));
    }

    public function create()
    {
        $user_id = auth()->user()->id;
        $periode = Carbon::now()->format('Y');
        $formasi_tim = FormasiTim::orWhere('anggota_id', $user_id)
                        ->orWhere('koordinator_id', $user_id)
                        ->where('periode', $periode)
                        ->firstOrFail();
        $kategori = Kategori::where('seksi_id', $formasi_tim->struktur->seksi->id)->get();
        return view('pages.kinerja.create', compact([
            'formasi_tim',
            'kategori',
        ]));
    }

    public function store(Request $request)
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

        return redirect()->route('kinerja.saya')->withNotify('Data Laporan Kinerja berhasil ditambahkan!');
    }

    public function filter(Request $request)
    {
        $anggota_id = $request->anggota_id;
        $pulau_id = $request->pulau_id;
        $seksi_id = $request->seksi_id;
        $koordinator_id = $request->koordinator_id;
        $tim_id = $request->tim_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;

        $kinerja = Kinerja::query();

        // Filter by anggota_id
        $kinerja->when($anggota_id, function ($query) use ($request) {
            return $query->whereRelation('anggota', 'uuid', '=', $request->anggota_id);
        });

        // Filter by pulau_id
        $kinerja->when($pulau_id, function ($query) use ($request) {
            return $query->where('pulau_id', $request->pulau_id);
        });

        // Filter by seksi_id
        $kinerja->when($seksi_id, function ($query) use ($request) {
            return $query->where('seksi_id', $request->seksi_id);
        });

        // Filter by koordinator_id
        $kinerja->when($koordinator_id, function ($query) use ($request) {
            return $query->where('koordinator_id', $request->koordinator_id);
        });

        // Filter by tim_id
        $kinerja->when($tim_id, function ($query) use ($request) {
            return $query->where('tim_id', $request->tim_id);
        });

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $kinerja->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('tanggal', '>=', $start_date);
            });
            $kinerja->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('tanggal', '<=', $end_date);
            });
        }

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $seksi  = Seksi::all();
        $koordinator  = User::whereRelation('jabatan', 'id', '=', 4)->get();
        $tim = Tim::orderBy('name', 'ASC')->get();

        $page = $anggota_id == null ? 'pages.kinerja.index' : 'pages.kinerja.my_index';

        return view($page, [
            'kinerja' => $kinerja->orderBy('tanggal', 'DESC')->get(),
            'pulau' => $pulau,
            'seksi' => $seksi,
            'koordinator' => $koordinator,
            'tim' => $tim,
            'pulau_id' => $pulau_id,
            'seksi_id' => $seksi_id,
            'koordinator_id' => $koordinator_id,
            'tim_id' => $tim_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function excel(Request $request)
    {
        $anggota_id = $request->anggota_id;
        $pulau_id = $request->pulau_id;
        $seksi_id = $request->seksi_id;
        $koordinator_id = $request->koordinator_id;
        $tim_id = $request->tim_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;

        $waktu = Carbon::now()->format('Ymd');

        return Excel::download(new KinerjaExport($anggota_id, $pulau_id, $seksi_id, $koordinator_id, $tim_id, $start_date, $end_date), $waktu . '_data kinerja.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function edit(string $uuid)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        //
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->id;
        $kinerja = Kinerja::findOrFail($id);
        if($kinerja->photo != null)
        {
            foreach(json_decode($kinerja->photo) as $photo)
            {
                Storage::delete($photo);
            }
        }
        $kinerja->forceDelete();
        return redirect()->route('kinerja.saya')->withNotify('Data berhasil dihapus!');
    }

    public function formasi()
    {
        $this_year = Carbon::now()->format('Y');
        $timIds = FormasiTim::where('periode', $this_year)->distinct()->pluck('struktur_id');
        $formasi_tim = [];

        foreach ($timIds as $timId) {
            $data = FormasiTim::where('periode', $this_year)->where('struktur_id', $timId)->first();
            $anggota_ids = FormasiTim::where('periode', $this_year)->where('struktur_id', $timId)->distinct()->pluck('anggota_id');
            $anggota = User::whereIn('id', $anggota_ids)->get(['name', 'photo']);

            $formasi_tim[] = [
                'tim' => $data->struktur->tim->name,
                'seksi' => $data->struktur->seksi->name,
                'koordinator' => $data->koordinator,
                'pulau' => $data->area->pulau->name,
                'anggota' => $anggota,
            ];
        }

        return view('pages.kinerja.formasi', ['formasi_tim' => $formasi_tim]);
    }
}

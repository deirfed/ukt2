<?php

namespace App\Http\Controllers\user\simoja;

use App\Exports\kinerja\user\KinerjaExport;
use App\Http\Controllers\Controller;
use App\Models\FormasiTim;
use App\Models\Kategori;
use App\Models\Kinerja;
use App\Models\Pulau;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KinerjaController extends Controller
{
    // KASI
    public function index(Request $request)
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $perPage = $request->perPage ?? 50;

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                ->where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();
        $pulau = Pulau::orderBy('name', 'ASC')->get();

        $user_id = '';
        $pulau_id = '';
        $start_date = '';
        $end_date = '';
        $sort = 'DESC';

        $kinerja = Kinerja::where('seksi_id', $seksi_id)
                ->orderBy('tanggal', $sort)
                ->paginate($perPage);

        return view('user.simoja.kasi.kinerja.index', [
            'kinerja' => $kinerja,
            'user' => $user,
            'pulau' => $pulau,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
            'perPage' => $perPage,
        ]);
    }

    public function filter_kasi(Request $request)
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $user_id = $request->user_id;
        $pulau_id = $request->pulau_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort;

        $kinerja = Kinerja::query();

        $kinerja->where('seksi_id', $seksi_id);

        // Filter by user_id
        $kinerja->when($user_id, function ($query) use ($request) {
            return $query->where('anggota_id', $request->user_id)->orWhere('koordinator_id', $request->user_id);
        });

        // Filter by pulau_id
        $kinerja->when($pulau_id, function ($query) use ($request) {
            $anggota_id = FormasiTim::where('periode', Carbon::now()->year)
                        ->whereRelation('area.pulau', 'id', '=', $request->pulau_id)
                        ->pluck('anggota_id')
                        ->toArray();

            $koordinator_id = FormasiTim::where('periode', Carbon::now()->year)
                        ->whereRelation('area.pulau', 'id', '=', $request->pulau_id)
                        ->pluck('koordinator_id')
                        ->toArray();
            $user_id = array_unique(array_merge($anggota_id, $koordinator_id));

            return $query->where(function($query) use ($user_id) {
                $query->whereIn('anggota_id', $user_id)
                        ->orWhereIn('koordinator_id', $user_id);
            });
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

        // Order By
        $kinerja = $kinerja->orderBy('tanggal', $sort)
                        ->orderBy('created_at', $sort)
                        ->paginate();

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                ->where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();

        return view('user.simoja.kasi.kinerja.index', [
            'kinerja' => $kinerja,
            'user' => $user,
            'pulau' => $pulau,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
        ]);
    }

    public function export_excel_kasi(Request $request)
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $user_id = $request->user_id;
        $pulau_id = $request->pulau_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort;

        $waktu = Carbon::now()->format('Ymd');
        $nama_file = $waktu . '_data kinerja.xlsx';

        return Excel::download(new KinerjaExport(
            $seksi_id,
            $user_id,
            $pulau_id,
            $start_date,
            $end_date,
            $sort),
            $nama_file,
            \Maatwebsite\Excel\Excel::XLSX);
    }

    public function export_pdf_kasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'start_date' => 'date|required',
        ]);

        $user_id = $request->user_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date) ?? $start_date;

        $user = FormasiTim::where('periode', Carbon::now()->year)->where('anggota_id', $user_id)->first();
        $kinerja = Kinerja::where('anggota_id', $user_id)
                            ->whereBetween('tanggal', [$start_date, $end_date])
                            ->get()
                            ->pluck('tanggal');

        $datesInRange = [];
        for ($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $kerja = Kinerja::where('anggota_id', $user_id)
                            ->whereDate('tanggal', $date)
                            ->get();

            $bg = $kerja->isNotEmpty() ? '' : 'bg-danger';

            $kegiatan = [];
            $deskripsi = [];
            $lokasi = [];
            $photo = [];

            foreach($kerja as $item)
            {
                $kegiatan[] = $item->kategori ? $item->kategori->name : $item->kegiatan;
                $deskripsi[] = $item->deskripsi ?? '-';
                $lokasi[] = $item->lokasi ?? '-';
                $photo[] = $item->photo ?? '-';
            }

            $datesInRange[] = [
                'hari' => $date->isoFormat('dddd'),
                'tanggal' => $date->copy(),
                'kegiatan' => $kegiatan,
                'deskripsi' => $deskripsi,
                'lokasi' => $lokasi,
                'photo' => $photo,
                'bg' => $bg,
            ];
        }

        $pdf = Pdf::loadView('user.simoja.kasi.kinerja.export.pdf', [
            'user' => $user,
            'datesInRange' => $datesInRange,
            'kinerja' => $kinerja,
            'start_date' => $start_date->isoFormat('D MMMM Y'),
            'end_date' => $end_date->isoFormat('D MMMM Y'),
        ]);

        return $pdf->setPaper('A4', 'landscape')->stream(Carbon::now()->format('Ymd_') . 'Data Kinerja_' . $user->anggota->name . '_' . $user->anggota->nip . '_Seksi ' . $user->struktur->seksi->name . '_Pulau ' . $user->area->pulau->name . '.pdf');
    }





    // KOORDINATOR
    public function tim_index_koordinator(Request $request)
    {
        $user_id = auth()->user()->id;
        $this_year = Carbon::now()->year;
        $anggota_id = FormasiTim::where('periode', $this_year)
                                ->where('koordinator_id', $user_id)
                                ->pluck('anggota_id')
                                ->toArray();
        $anggota_id[] = $user_id;

        $perHalaman = $request->input('perHalaman', 25);

        $kinerja = Kinerja::whereIn('anggota_id', $anggota_id)
                        ->orderBy('tanggal', 'DESC')
                        ->paginate($perHalaman);

        return view('user.simoja.koordinator.kinerja.tim_index', compact([
            'kinerja'
        ]));
    }

    public function my_index_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

        $user_id = auth()->user()->id;
        $kinerja = Kinerja::where('anggota_id', $user_id)
                        ->orderBy('tanggal', 'DESC')
                        ->get();
        return view('user.simoja.koordinator.kinerja.my_index', compact([
            'kinerja'
        ]));
    }

    public function create_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }
        $user_id = auth()->user()->id;
        $formasi_tim = FormasiTim::where('koordinator_id', $user_id)
                                ->orWhere('anggota_id', $user_id)
                                ->firstOrFail();
        $kategori = Kategori::where('seksi_id', $formasi_tim->struktur->seksi->id)->get();

        return view('user.simoja.koordinator.kinerja.create', compact([
            'formasi_tim',
            'kategori'
        ]));
    }

    public function store_koordinator(Request $request)
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

        return redirect()->route('simoja.koordinator.my-kinerja')->withNotify('Data Laporan Kinerja berhasil ditambahkan!');
    }








    // PJLP
    public function my_index_pjlp(Request $request)
    {
        $user_id = auth()->user()->id;

        $start_date = '';
        $end_date = '';
        $sort = 'DESC';

        $perPage = $request->perPage ?? 50;

        $kinerja = Kinerja::where('anggota_id', $user_id)
                        ->orderBy('tanggal', $sort)
                        ->paginate($perPage);

        return view('user.simoja.pjlp.kinerja.my_index', [
            'kinerja' => $kinerja,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
        ]);
    }

    public function create_pjlp()
    {
        $user_id = auth()->user()->id;
        $formasi_tim = FormasiTim::where('koordinator_id', $user_id)
                    ->orWhere('anggota_id', $user_id)
                    ->firstOrFail();

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

    public function filter_pjlp(Request $request)
    {
        $user_id = auth()->user()->id;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort;

        $kinerja = Kinerja::query();

        // Filter by user_id
        $kinerja->where('anggota_id', $user_id);

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $kinerja->whereBetween('tanggal', [$start_date, $end_date]);
        }

        // Order By
        $kinerja = $kinerja->orderBy('tanggal', $sort)
                        ->orderBy('created_at', $sort)
                        ->paginate();


        return view('user.simoja.pjlp.kinerja.my_index', [
            'kinerja' => $kinerja,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
        ]);
    }
}

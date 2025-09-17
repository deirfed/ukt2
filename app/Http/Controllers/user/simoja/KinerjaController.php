<?php

namespace App\Http\Controllers\user\simoja;

use App\DataTables\KinerjaDataTable;
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
    public function index(KinerjaDataTable $dataTable, Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'pulau_id' => 'nullable|exists:pulau,id',
            'kategori_id' => 'nullable|exists:kategori,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user_id = $request->user_id ?? null;
        $pulau_id = $request->pulau_id ?? null;
        $kategori_id = $request->kategori_id ?? null;

        $periode = Carbon::now()->format('Y');

        $start_date = $request->start_date ?? Carbon::createFromFormat('Y', $periode)->startOfYear()->toDateString();
        $end_date = $request->end_date ?? Carbon::createFromFormat('Y', $periode)->endOfYear()->toDateString();


        $seksi_id = auth()->user()->struktur->seksi->id;

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                    ->where('employee_type_id', 3)
                    ->notBanned()
                    ->orderBy('name', 'ASC')
                    ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $kategori = Kategori::where('seksi_id', $seksi_id)->get();

        return $dataTable->with([
            'seksi_id' => $seksi_id,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'kategori_id' => $kategori_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('user.simoja.kasi.kinerja.index', compact([
            'user',
            'pulau',
            'kategori',
            'seksi_id',
            'user_id',
            'pulau_id',
            'kategori_id',
            'start_date',
            'end_date',
        ]));
    }

    public function filter_kasi(Request $request)
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $user_id = $request->user_id;
        $pulau_id = $request->pulau_id;
        $kategori_id = $request->kategori_id;
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

            return $query->where(function($query) use ($anggota_id) {
                $query->whereIn('anggota_id', $anggota_id);
            });
        });

        // Filter by kategori_id
        $kinerja->when($kategori_id, function ($query) use ($request) {
            return $query->where('kategori_id', $request->kategori_id);
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
                        ->paginate(10000000);

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                ->where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $kategori = Kategori::where('seksi_id', $seksi_id)->get();

        return view('user.simoja.kasi.kinerja.index', [
            'kinerja' => $kinerja,
            'user' => $user,
            'pulau' => $pulau,
            'kategori' => $kategori,
            'kategori_id' => $kategori_id,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
        ]);
    }

    public function export_excel_kasi(Request $request)
    {
        $seksi_id = $request->seksi_id ?? null;
        $user_id = $request->user_id ?? null;
        $pulau_id = $request->pulau_id ?? null;
        $kategori_id = $request->kategori_id ?? null;
        $start_date = $request->start_date ?? null;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort ?? 'ASC';

        $waktu = Carbon::now()->format('Ymd');
        $nama_file = $waktu . '_Data Kinerja.xlsx';

        return Excel::download(new KinerjaExport(
            $seksi_id,
            $user_id,
            $pulau_id,
            $kategori_id,
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
            'end_date' => 'date|required|after_or_equal:start_date',
        ]);

        $user_id = $request->user_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date) ?? $start_date;

        $user = FormasiTim::where('anggota_id', $user_id)->first();

        $kepala_seksi = User::where('jabatan_id', 2) //Kepala Seksi
                        ->where('struktur_id', $user->struktur_id)
                        ->orderBy('updated_at', 'DESC')
                        ->first();

        $kinerja = Kinerja::where('anggota_id', $user_id)
                            ->whereBetween('tanggal', [$start_date, $end_date])
                            ->orderBy('tanggal', 'ASC')
                            ->get();

        $pdf = Pdf::loadView('user.simoja.kasi.kinerja.export.pdf', [
            'user' => $user,
            'kepala_seksi' => $kepala_seksi,
            'kinerja' => $kinerja,
            'start_date' => $start_date->isoFormat('D MMMM Y'),
            'end_date' => $end_date->isoFormat('D MMMM Y'),
        ]);

        return $pdf->setPaper('A4', 'potrait')->stream(Carbon::now()->format('Ymd_') . 'Data Kinerja.pdf');
    }

    public function export_pdf_kegiatan_kasi(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,id',
            'user_id' => 'nullable|exists:users,id',
            'start_date' => 'date|required',
            'end_date' => 'date|required|after_or_equal:start_date',
        ]);

        $kategori_id = $request->kategori_id;
        $user_id = $request->user_id;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date) ?? $start_date;

        $kategori = Kategori::findOrFail($kategori_id);

        $query = Kinerja::query();

        $query->where('kategori_id', $kategori_id);

        if ($user_id) {
            $query->where('anggota_id', $user_id);
        }

        $kinerja = $query->whereBetween('tanggal', [$start_date, $end_date])
                            ->orderBy('tanggal', 'ASC')
                            ->get();

        $pdf = Pdf::loadView('user.simoja.kasi.kinerja.export.pdf_kegiatan', [
            'kategori' => $kategori,
            'kinerja' => $kinerja,
            'start_date' => $start_date->isoFormat('D MMMM Y'),
            'end_date' => $end_date->isoFormat('D MMMM Y'),
        ]);

        return $pdf->setPaper('A4', 'potrait')->stream(Carbon::now()->format('Ymd_') . 'Data Kinerja_Kegiatan ' . $kategori->name . '.pdf');
    }

    public function export_pdf_all_kasi(Request $request)
    {
        $request->validate([
            'seksi_id' => 'nullable|exists:seksi,id',
            'user_id' => 'nullable|exists:users,id',
            'pulau_id' => 'nullable|exists:pulau,id',
            'kategori_id' => 'nullable|exists:kategori,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $seksi_id = $request->seksi_id ?? null;
        $user_id = $request->user_id ?? null;
        $pulau_id = $request->pulau_id ?? null;
        $kategori_id = $request->kategori_id ?? null;
        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date) ?? $start_date;

        $query = Kinerja::query();

        if ($seksi_id) {
            $query->where('seksi_id', $seksi_id);
        }

        if ($user_id) {
            $query->where('anggota_id', $user_id);
        }

        if ($pulau_id) {
            $query->where('pulau_id', $pulau_id);
        }

        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }

        if ($start_date) {
            $query->whereBetween('tanggal', [$start_date, $end_date]);
        }

        $kinerja = $query->orderBy('tanggal', 'ASC')->get();

        $pdf = Pdf::loadView('user.simoja.kasi.kinerja.export.pdf_all', [
            'kinerja' => $kinerja,
            'start_date' => $start_date->isoFormat('D MMMM Y'),
            'end_date' => $end_date->isoFormat('D MMMM Y'),
        ]);

        return $pdf->setPaper('A4', 'potrait')->stream(Carbon::now()->format('Ymd_') . 'Data Kinerja.pdf');
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

        $search = $request->input('search');

        $kinerjaQuery = Kinerja::whereIn('anggota_id', $anggota_id)
                        ->orderBy('tanggal', 'DESC');

        if ($search) {
            $kinerjaQuery->where(function ($query) use ($search) {
                $query->whereHas('anggota', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('pulau', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('kategori', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('kegiatan', 'LIKE', "%{$search}%")
                ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                ->orWhere('lokasi', 'LIKE', "%{$search}%")
                ->orWhere('tanggal', 'LIKE', "%{$search}%");
            });
        }

        $kinerja = $kinerjaQuery->paginate($perHalaman);

        $kinerja->appends(['search' => $search]);

        return view('user.simoja.koordinator.kinerja.tim_index', compact('kinerja'));
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
    public function my_index_pjlp(KinerjaDataTable $dataTable, Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'pulau_id' => 'nullable|exists:pulau,id',
            'kategori_id' => 'nullable|exists:kategori,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $periode = Carbon::now()->format('Y');

        $start_date = $request->start_date ?? Carbon::createFromFormat('Y', $periode)->startOfYear()->toDateString();
        $end_date = $request->end_date ?? Carbon::createFromFormat('Y', $periode)->endOfYear()->toDateString();
        $user_id = auth()->user()->id;

        return $dataTable->with([
            'user_id' => $user_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('user.simoja.pjlp.kinerja.my_index', compact([
            'start_date',
            'end_date',
        ]));
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

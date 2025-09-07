<?php

namespace App\Http\Controllers\user\simoja;

use App\DataTables\AbsensiDataTable;
use App\DataTables\AbsensiSayaDataTable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pulau;
use App\Models\Absensi;
use App\Models\Kinerja;
use App\Models\FormasiTim;
use App\Models\JenisAbsensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KonfigurasiAbsensi;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Exports\absensi\AbsensiExport;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    // KASI
    public function index_kasi(AbsensiDataTable $dataTable, Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'pulau_id' => 'nullable|exists:pulau,id',
            'periode' => 'nullable',
        ]);

        $user_id = $request->user_id ?? null;
        $pulau_id = $request->pulau_id ?? null;
        $periode = $request->periode ?? Carbon::now()->format('Y-m');

        $start_date = Carbon::createFromFormat('Y-m', $periode)->startOfMonth()->toDateString();
        $end_date   = Carbon::createFromFormat('Y-m', $periode)->endOfMonth()->toDateString();

        $seksi_id = auth()->user()->struktur->seksi->id;

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                    ->where('employee_type_id', 3) //PJLP Only
                    ->notBanned()
                    ->orderBy('name', 'ASC')
                    ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();

        return $dataTable->with([
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('user.simoja.kasi.absensi.index', compact([
            'user',
            'pulau',
            'user_id',
            'pulau_id',
            'start_date',
            'end_date',
            'periode',
        ]));
    }

    public function filter_kasi(Request $request)
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $user_id = $request->user_id;
        $pulau_id = $request->pulau_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort;

        $absensi = Absensi::query();

        $absensi->whereRelation('user.struktur.seksi', 'id', '=', $seksi_id);

        // Filter by user_id
        $absensi->when($user_id, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        });

        // Filter by pulau_id
        $absensi->when($pulau_id, function ($query) use ($request) {
            $user_id[] = FormasiTim::where('periode', Carbon::now()->year)
                    ->whereRelation('area.pulau', 'id', '=', $request->pulau_id)
                    ->pluck('anggota_id')
                    ->toArray();
            $user_id[] = FormasiTim::where('periode', Carbon::now()->year)
                    ->whereRelation('area.pulau', 'id', '=', $request->pulau_id)
                    ->pluck('koordinator_id')
                    ->toArray();
            $user_id = array_merge(...$user_id);
            return $query->whereIn('user_id', $user_id);
        });

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $absensi->whereBetween('tanggal', [$start_date, $end_date]);
        }

        // Order By
        $absensi = $absensi->orderBy('tanggal', $sort)
                        ->orderBy('jam_masuk', $sort)
                        ->orderBy('jam_pulang', $sort)
                        ->paginate(10000000);

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)->where('employee_type_id', 3)->orderBy('name', 'ASC')->get();
        $pulau = Pulau::orderBy('name', 'ASC')->get();

        return view('user.simoja.kasi.absensi.index', [
            'absensi' => $absensi,
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
        $sort = $request->sort ?? 'ASC';

        $waktu = Carbon::now()->format('Ymd');

        return Excel::download(new AbsensiExport($seksi_id, $user_id, $pulau_id, $start_date, $end_date, $sort), $waktu . '_data absensi.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function export_pdf_kasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode' => 'required',
        ]);

        $user_id = $request->user_id;
        $periode = $request->periode;

        $start_date = Carbon::createFromFormat('Y-m', $periode)->startOfMonth()->toDateString();
        $end_date   = Carbon::createFromFormat('Y-m', $periode)->endOfMonth()->toDateString();

        $start_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($end_date) ?? $start_date;

        $user = FormasiTim::where('periode', Carbon::now()->year)->where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->first();
        $absensi = Absensi::where('user_id', $user_id)
                            ->whereBetween('tanggal', [$start_date, $end_date])
                            ->get()
                            ->pluck('tanggal');

        $datesInRange = [];
        for ($date = $start_date->copy(); $date->lte($end_date); $date->addDay()) {
            $absen = Absensi::where('user_id', $user_id)
                        ->whereDate('tanggal', $date)
                        ->first();

            if($absen){
                if($absen->jam_masuk == null or $absen->jam_pulang == null){
                    $bg = 'bg-warning';
                } else {
                    $bg = '';
                }
            } else {
                $bg = 'bg-danger';
            }


            $datesInRange[] = [
                'hari' => $date->isoFormat('dddd'),
                'tanggal' => $date->copy(),
                'jam_masuk' => $absen->jam_masuk ?? '',
                'jam_pulang' => $absen->jam_pulang ?? '',
                'status' => $absen->status ?? 'Tidak Absen',
                'bg' => $bg,
                'url_photo_masuk' => $absen && $absen->photo_masuk ? public_path('storage/' . $absen->photo_masuk) : '',
                'url_photo_pulang' => $absen && $absen->photo_pulang ? public_path('storage/' . $absen->photo_pulang) : '',
            ];
        }

        $pdf = Pdf::loadView('user.simoja.kasi.absensi.export.pdf', [
            'user' => $user,
            'datesInRange' => $datesInRange,
            'absensi' => $absensi,
            'start_date' => $start_date->isoFormat('D MMMM Y'),
            'end_date' => $end_date->isoFormat('D MMMM Y'),
        ]);

        return $pdf->stream(Carbon::now()->format('Ymd_') . 'Data Absensi_' . $user->anggota->name . '_' . $user->anggota->nip . '_Seksi ' . $user->struktur->seksi->name . '_Pulau ' . $user->area->pulau->name . '.pdf');
    }



    public function ringkasan_kasi(Request $request)
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $koordinator_id = FormasiTim::where('periode', Carbon::now()->year)
                                ->whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                                ->distinct()
                                ->pluck('koordinator_id')
                                ->toArray();
        $anggota_id = FormasiTim::where('periode', Carbon::now()->year)
                                ->whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                                ->distinct()
                                ->pluck('anggota_id')
                                ->toArray();

        $user_id = array_merge($koordinator_id, $anggota_id);

        $absensi = Absensi::whereIn('user_id', $user_id)
            ->select('user_id', Absensi::raw('COUNT(DISTINCT tanggal) as total_hari_absen'))
            ->groupBy('user_id')
            ->orderByDesc('total_hari_absen')
            ->get();

        return view('user.simoja.kasi.absensi.summary', compact([
            'absensi',
        ]));
    }

    public function performance_personel(Request $request)
    {
        $request->validate([
            'tahun' => 'nullable'
        ]);

        $tahun = $request->tahun ?? Carbon::now()->format('Y');

        $seksi_id = auth()->user()->struktur->seksi->id;

        $users = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                    ->where('employee_type_id', 3)
                    ->notBanned()
                    ->orderBy('name', 'ASC')
                    ->get();

        $absensi = [];
        foreach ($users as $user) {
            $absensi_masuk = Absensi::where('user_id', $user->id)
                                    ->whereNotNull('jam_masuk')
                                    ->whereYear('tanggal', $tahun)
                                    ->count();

            $absensi_pulang = Absensi::where('user_id', $user->id)
                                    ->whereNotNull('jam_pulang')
                                    ->whereYear('tanggal', $tahun)
                                    ->count();

            $absensi[$user->name] = [
                'absen_masuk' => $absensi_masuk,
                'absen_pulang' => $absensi_pulang
            ];
        }

        $kinerja = [];
        foreach ($users as $user) {
            $jumlahKinerja = Kinerja::where('anggota_id', $user->id)
                                    ->whereYear('tanggal', $tahun)
                                    ->count();

            $kinerja[$user->name] = [
                'kinerja' => $jumlahKinerja,
            ];
        }
        return view('user.simoja.kasi.performa', compact([
            'tahun',
            'users',
            'absensi',
            'kinerja',
        ]));
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

        $perPage = $request->perPage ?? 50;

        $search = $request->input('search');

        $absensiQuery = Absensi::whereIn('user_id', $anggota_id)
                        ->orderBy('tanggal', 'DESC')
                        ->orderBy('jam_masuk', 'DESC')
                        ->orderBy('jam_pulang', 'DESC');

        if ($search) {
            $absensiQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('user.area.pulau', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('status_masuk', 'LIKE', "%{$search}%")
                ->orWhere('status_pulang', 'LIKE', "%{$search}%")
                ->orWhere('catatan_masuk', 'LIKE', "%{$search}%")
                ->orWhere('catatan_pulang', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        $absensi = $absensiQuery->paginate($perPage);

        $absensi->appends(['search' => $search]);

        return view('user.simoja.koordinator.absensi.tim_index', compact([
            'absensi',
            'perPage'
        ]));
    }

    public function my_index_koordinator(Request $request)
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

        $perPage = $request->perPage ?? 50;
        $user_id = auth()->user()->id;
        $absensi = Absensi::where('user_id', $user_id)
                    ->orderBy('tanggal', 'DESC')
                    ->orderBy('jam_masuk', 'DESC')
                    ->orderBy('jam_pulang', 'DESC')
                    ->paginate($perPage);

        return view('user.simoja.koordinator.absensi.my_index', compact([
            'absensi',
            'perPage'
        ]));
    }

    public function create_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

        $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenis_absensi = JenisAbsensi::findOrFail(1);
        return view('user.simoja.koordinator.absensi.create', compact([
            'tanggal',
            'jenis_absensi',
        ]));
    }

    public function store_koordinator(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $img = $request->photo;

        $now = Carbon::now();
        $tanggal = Carbon::parse($now)->format('Y-m-d');
        $waktu = Carbon::parse($now);
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $jam_masuk = Carbon::parse($konfigurasi_absensi->jam_masuk);
        $jam_pulang = Carbon::parse($konfigurasi_absensi->jam_pulang);

        $user_id = auth()->user()->id;
        $latitude = 'xxx';
        $longitude = 'xxx';
        $batas_mulai_absen_masuk = '05:00:00';
        $batas_selesai_absen_masuk = '12:00:00';
        $batas_mulai_absen_pulang = '12:00:00';
        $batas_selesai_absen_pulang = '22:00:00';

        if($waktu >= Carbon::parse($batas_mulai_absen_masuk) and $waktu <= Carbon::parse($batas_selesai_absen_masuk)) {
            $validasi = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan Absen Masuk hari ini.');
            }

            $status = 'Absen Masuk';

            if($waktu > $jam_masuk) {
                $status_absen = 'Terlambat Masuk';
                $telat = $waktu->diffInMinutes($jam_masuk);
            } else {
                $status_absen = 'Tepat Waktu';
                $telat = 0;
            }
        } elseif($waktu > Carbon::parse($batas_mulai_absen_pulang) and $waktu <= Carbon::parse($batas_selesai_absen_pulang)) {
            $validasi = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan Absen Pulang hari ini.');
            }

            $status = 'Absen Pulang';

            if($waktu < $jam_pulang) {
                $status_absen = 'Pulang Cepat';
                $telat = $waktu->diffInMinutes($jam_pulang);
            } else {
                $status_absen = 'Tepat Waktu';
                $telat = 0;
            }
        } else {
            return back()->withError('Anda tidak bisa melakukan absensi di waktu saat ini.');
        }

        $folderPath = "absensi/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;

        Storage::put($file, $image_base64);

        $validasiTanggal = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
        if($validasiTanggal == 0 and $status == 'Absen Masuk') {
            Absensi::create([
                'jenis_absensi_id' => 1,
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'jam_masuk' => $waktu,
                'telat_masuk' => $telat,
                'photo_masuk' => $file,
                'latitude_masuk' => $latitude,
                'longitude_masuk' => $longitude,
                'status_masuk' => $status_absen,
                'status'=> $status,
            ]);
        } else {
            $absensi =Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->first();
            if ($absensi){
                if($absensi->jam_pulang != null) {
                    return back()->withNotify('Anda sudah absen hari ini.');
                }
                $absensi->update([
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'photo_pulang' => $file,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absen,
                    'status'=> $status,
                ]);
            } else {
                Absensi::create([
                    'jenis_absensi_id' => 1,
                    'user_id' => $user_id,
                    'tanggal' => $tanggal,
                    'status_masuk' => 'Tidak Absen Masuk',
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'photo_pulang' => $file,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absen,
                    'status'=> 'Tidak Absen Masuk',
                ]);
                return redirect()->route('simoja.koordinator.my-absensi')->withNotify('Anda tidak melakukan Absen Masuk di waktu yang ditentukan, data ini disimpan Absen Pulang!');
            }
        }

        return redirect()->route('simoja.koordinator.my-absensi')->withNotify('Data ' . $status . ' Berhasil Disimpan!');
    }











    // PJLP
    public function my_index_pjlp(AbsensiSayaDataTable $dataTable, Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $periode = Carbon::now()->format('Y-m');
        $start_date = $request->start_date ?? Carbon::createFromFormat('Y-m', $periode)->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? Carbon::createFromFormat('Y-m', $periode)->endOfMonth()->toDateString();

        return $dataTable->with([
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('user.simoja.pjlp.absensi.my_index', compact([
            'start_date',
            'end_date',
        ]));
    }
    public function create_pjlp()
    {
        $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $now = Carbon::now();
        $waktu = Carbon::parse($now);
        $jenis_absensi = JenisAbsensi::findOrFail(1);
        $user_id = auth()->user()->id;
        $formasi_tim = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail();

        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $batas_mulai_absen_masuk = Carbon::parse($konfigurasi_absensi->mulai_absen_masuk);
        $batas_selesai_absen_masuk = Carbon::parse($konfigurasi_absensi->selesai_absen_masuk);
        $batas_mulai_absen_pulang = Carbon::parse($konfigurasi_absensi->mulai_absen_pulang);
        $batas_selesai_absen_pulang = Carbon::parse($konfigurasi_absensi->selesai_absen_pulang);

        if($waktu >= $batas_mulai_absen_masuk and $waktu <= $batas_selesai_absen_masuk) {
            $mode = 'Absensi Datang';
        }
        elseif($waktu >= $batas_mulai_absen_pulang and $waktu <= $batas_selesai_absen_pulang) {
            $mode = 'Absensi Pulang';
        }
        else {
            $mode = 'Sekarang bukan waktu untuk Absensi';
        }

        return view('user.simoja.pjlp.absensi.create', compact([
            'jenis_absensi',
            'tanggal',
            'mode',
            'formasi_tim',
        ]));
    }

    public function store_pjlp(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $img = $request->photo;
        $catatan = $request->catatan;

        $now = Carbon::now();
        $tanggal = Carbon::parse($now)->format('Y-m-d');
        $waktu = Carbon::parse($now);
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $toleransi_masuk = $konfigurasi_absensi->toleransi_masuk;
        $toleransi_pulang = $konfigurasi_absensi->toleransi_pulang;
        $jam_masuk = Carbon::parse($konfigurasi_absensi->jam_masuk)->addMinutes($toleransi_masuk);
        $jam_pulang = Carbon::parse($konfigurasi_absensi->jam_pulang)->subMinutes($toleransi_pulang);

        $user_id = auth()->user()->id;
        $latitude = 'xxx';
        $longitude = 'xxx';

        $mode = '';
        $telat = '';
        $status_absensi = '';

        $batas_mulai_absen_masuk = Carbon::parse($konfigurasi_absensi->mulai_absen_masuk);
        $batas_selesai_absen_masuk = Carbon::parse($konfigurasi_absensi->selesai_absen_masuk);
        $batas_mulai_absen_pulang = Carbon::parse($konfigurasi_absensi->mulai_absen_pulang);
        $batas_selesai_absen_pulang = Carbon::parse($konfigurasi_absensi->selesai_absen_pulang);

        $hari = Carbon::parse($waktu)->isoFormat('dddd');
        if($hari == 'Jumat'){
            $jam_pulang = $jam_pulang->addMinutes(30);
            $batas_mulai_absen_pulang = $batas_mulai_absen_pulang->addMinutes(30);
        }

        $formasi = FormasiTim::where('periode', Carbon::now()->year)->where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->first();
        $nama = strtoupper($formasi->anggota->name) . ' - ' . $formasi->anggota->nip;
        $jam = Carbon::parse($waktu)->format('H:i:s') . ' WIB';
        $date = Carbon::parse($waktu)->isoFormat('dddd, D MMMM Y') . ' - ' . $jam;
        $seksi = 'Seksi ' . $formasi->struktur->seksi->name;
        $pulau = 'Pulau ' . $formasi->area->pulau->name;

        if($waktu >= $batas_mulai_absen_masuk and $waktu <= $batas_selesai_absen_masuk) {
            $mode = 'Absensi Datang';
            if ($waktu > $jam_masuk){
                $telat = $waktu->diffInMinutes($jam_masuk);
                $status_absensi = 'Datang terlambat';

            } else {
                $telat = 0;
                $status_absensi = 'Datang tepat waktu';
            }
        }
        elseif($waktu >= $batas_mulai_absen_pulang and $waktu <= $batas_selesai_absen_pulang) {
            $mode = 'Absensi Pulang';
            if ($waktu < $jam_pulang){
                $telat = $waktu->diffInMinutes($jam_pulang);
                $status_absensi = 'Pulang Cepat';

            } else {
                $telat = 0;
                $status_absensi = 'Pulang tepat waktu';
            }
        }
        else {
            return back()->withError('Anda harus melakukan absensi, pada rentan Waktu yang telah ditentukan!');
        }

        if ($mode == 'Absensi Datang') {
            $validasi = Absensi::where('user_id', $user_id)
                        ->whereDate('tanggal', $tanggal)
                        ->where('jam_masuk', '!=', null)
                        ->count();

            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan ' . $mode . ' hari ini.');
            }

            $absensi = Absensi::create([
                'jenis_absensi_id' => 1,
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'jam_masuk' => $waktu,
                'telat_masuk' => $telat,
                'latitude_masuk' => $latitude,
                'longitude_masuk' => $longitude,
                'status_masuk' => $status_absensi,
                'status' => $mode,
                'catatan_masuk' => $catatan,
            ]);
        } else {
            $validasi = Absensi::where('user_id', $user_id)
                        ->whereDate('tanggal', $tanggal)
                        ->where('jam_pulang', '!=', null)
                        ->count();

            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan ' . $mode . ' hari ini.');
            } else {
                $mode = 'Absensi Pulang';
            }

            $absensi = Absensi::where('user_id', $user_id)
                            ->whereDate('tanggal', $tanggal)
                            ->first();

            if($absensi) {
                $absensi->update([
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absensi,
                    'status'=> $mode,
                    'catatan_pulang' => $catatan,
                ]);
            } else {
                $absensi = Absensi::create([
                    'jenis_absensi_id' => 1,
                    'user_id' => $user_id,
                    'tanggal' => $tanggal,
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absensi,
                    'status'=> 'Tidak Absen Datang',
                    'catatan_pulang' => $catatan,
                ]);
            }
        }

        $folderPath = "absensi/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;

        Storage::put($file, $image_base64);

        $absen = Absensi::find($absensi->id);



        if ($mode == 'Absensi Pulang') {
            $absen->update([
                'photo_pulang' => $file,
            ]);

            $path = public_path('storage/'. $absen->photo_pulang);
            $pathWatermark = public_path('assets/img/watermark.png');
            $imageName = basename($path);
            $image = Image::make($path);

            $image->insert($pathWatermark, 'bottom-center', 0, 0);
            $image->text($nama, 150, 245, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(13);
            });
            $image->text($mode, 150, 260, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($date, 150, 270, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($seksi, 150, 280, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($pulau, 150, 290, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });

            $destinationPath = public_path('storage/'. $folderPath);

            $image->save($destinationPath.$imageName);

            $message = 'Data absensi berhasil disimpan!';
        } else {
            $absen->update([
                'photo_masuk' => $file,
            ]);

            $path = public_path('storage/'. $absen->photo_masuk);
            $pathWatermark = public_path('assets/img/watermark.png');
            $imageName = basename($path);
            $image = Image::make($path);

            $image->insert($pathWatermark, 'bottom-center', 0, 0);
            $image->text($nama, 150, 245, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(13);
            });
            $image->text($mode, 150, 260, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($date, 150, 270, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($seksi, 150, 280, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($pulau, 150, 290, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });

            $destinationPath = public_path('storage/'. $folderPath);

            $image->save($destinationPath.$imageName);

            $message = 'Data absensi berhasil disimpan!';
        }

        return redirect()->route('simoja.pjlp.my-absensi')->withNotify($message);
    }

    public function filter_pjlp(Request $request)
    {
        $user_id = auth()->user()->id;
        $pulau_id = null;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort;

        $absensi = Absensi::query();


        // Filter by user_id
        $absensi->when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });

        // Filter by pulau_id
        $absensi->when($pulau_id, function ($query) use ($request) {
            $user_id[] = FormasiTim::where('periode', Carbon::now()->year)
                    ->whereRelation('area.pulau', 'id', '=', $request->pulau_id)
                    ->pluck('anggota_id')
                    ->toArray();

            $user_id[] = FormasiTim::where('periode', Carbon::now()->year)
                    ->whereRelation('area.pulau', 'id', '=', $request->pulau_id)
                    ->pluck('koordinator_id')
                    ->toArray();

            $user_id = array_merge(...$user_id);
            return $query->whereIn('user_id', $user_id);
        });

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $absensi->whereBetween('tanggal', [$start_date, $end_date]);
        }

        // Order By
        $absensi = $absensi->orderBy('tanggal', $sort)
                        ->orderBy('jam_masuk', $sort)
                        ->orderBy('jam_pulang', $sort)
                        ->paginate();

        return view('user.simoja.pjlp.absensi.my_index', [
            'absensi' => $absensi,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
        ]);
    }
}

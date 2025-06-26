<?php

namespace App\Http\Controllers\user\simoja;

use App\Exports\cuti\user\CutiExport;
use App\Http\Controllers\Controller;
use App\Mail\CutiMail;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\FormasiTim;
use App\Models\JenisCuti;
use App\Models\KonfigurasiAbsensi;
use App\Models\KonfigurasiCuti;
use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\Tim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class CutiController extends Controller
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
        $jenis_cuti = JenisCuti::all();

        $search = $request->input('search');

        $cutiQuery = Cuti::whereRelation('user.struktur.seksi', 'id', '=', $seksi_id);

        if ($search) {
            $cutiQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('user.area.pulau', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('known_by', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('approved_by', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('jenis_cuti', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('jumlah', 'LIKE', "%{$search}%");
            });
        }

        $cuti = $cutiQuery->orderBy('tanggal_awal', 'DESC')
            ->orderBy('tanggal_akhir', 'DESC')
            ->paginate($perPage);

        $cuti->appends(['search' => $search]);

        return view('user.simoja.kasi.cuti.index', [
            'cuti' => $cuti,
            'user' => $user,
            'pulau' => $pulau,
            'jenis_cuti' => $jenis_cuti,
            'jenis_cuti_id' => '',
            'user_id' => '',
            'pulau_id' => '',
            'start_date' => '',
            'end_date' => '',
            'sort' => 'DESC',
            'status' => '',
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
        $status = $request->status;
        $jenis_cuti_id = $request->jenis_cuti_id;

        $user = User::whereRelation('struktur.seksi', 'id', '=', $seksi_id)
                ->where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $jenis_cuti = JenisCuti::all();

        $cuti = Cuti::query();

        $cuti->whereRelation('user.struktur.seksi', 'id', '=', $seksi_id);

        // Filter by user_id
        $cuti->when($user_id, function ($query) use ($request) {
            return $query->where('user_id', $request->user_id);
        });

        // Filter by pulau_id
        $cuti->when($pulau_id, function ($query) use ($request) {
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
                $query->whereIn('user_id', $user_id);
            });
        });

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $cuti->whereBetween('tanggal_awal', [$start_date, $end_date]);
        }

        // Filter by jenis_cuti_id
        $cuti->when($jenis_cuti_id, function ($query) use ($request) {
            return $query->where('jenis_cuti_id', $request->jenis_cuti_id);
        });

        // Filter by status
        $cuti->when($status, function ($query) use ($request) {
            return $query->where('status', $request->status);
        });

        // Order By
        $cuti = $cuti->orderBy('tanggal_awal', $sort)
                    ->orderBy('tanggal_akhir', $sort)
                    ->paginate(10000000);

        return view('user.simoja.kasi.cuti.index', [
            'cuti' => $cuti,
            'user' => $user,
            'pulau' => $pulau,
            'jenis_cuti' => $jenis_cuti,
            'jenis_cuti_id' => $jenis_cuti_id,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
            'status' => $status,
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
        $status = $request->status;
        $jenis_cuti_id = $request->jenis_cuti_id;

        $waktu = Carbon::now()->format('Ymd');
        $nama_file = $waktu . '_data cuti.xlsx';

        return Excel::download(new CutiExport(
            $seksi_id,
            $user_id,
            $pulau_id,
            $start_date,
            $end_date,
            $sort,
            $status,
            $jenis_cuti_id),
            $nama_file,
            \Maatwebsite\Excel\Excel::XLSX);
    }

    public function approval()
    {
        $approval_cuti = Cuti::where('approved_by_id', auth()->user()->id)
                        ->where('status', 'Diproses')->get();

        return view('user.simoja.kasi.cuti.approval', compact([
            'approval_cuti',
        ]));
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'no_surat' => 'required',
        ]);
        $cuti = Cuti::findOrFail($request->id);
        $konfigurasi_cuti = KonfigurasiCuti::where('user_id', $cuti->user_id)->firstOrFail();
        $cuti->status = 'Diterima';
        $cuti->no_surat = $request->no_surat;
        $cuti->save();

        if($cuti->jenis_cuti->id == 1){
            $konfigurasi_cuti->jumlah = $konfigurasi_cuti->jumlah - $cuti->jumlah;
            $konfigurasi_cuti->save();
        }


        for ($date = Carbon::parse($cuti->tanggal_awal); $date->lte(Carbon::parse($cuti->tanggal_akhir)); $date->addDay()) {
            $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
            Absensi::create([
                'user_id' => $cuti->user_id,
                'jenis_absensi_id' => 1,
                'tanggal' => $date->copy(),
                'jam_masuk' => $konfigurasi_absensi->jam_masuk,
                'status_masuk' => 'Datang tepat waktu',
                'telat_masuk' => 0,
                'jam_pulang' => $konfigurasi_absensi->jam_pulang,
                'status_pulang' => 'Pulang tepat waktu',
                'cepat_pulang' => 0,
                'status' => $cuti->jenis_cuti->name,
            ]);
        }

        return redirect()->route('simoja.kasi.cuti.approval')->withNotify('Data berhasil diterima!');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        $cuti->status = 'Ditolak';
        $cuti->save();

        return redirect()->route('simoja.kasi.cuti.approval')->withNotify('Data berhasil ditolak!');
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

        $perPage = $request->perPage ?? 25;

        $search = $request->input('search');

        $cutiQuery = Cuti::whereIn('user_id', $anggota_id)
                        ->orderBy('tanggal_awal', 'DESC');

        if ($search) {
            $cutiQuery->where(function ($query) use ($search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('user.area.pulau', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('jenis_cuti', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhere('jumlah', 'LIKE', "%{$search}%");
            });
        }

        $cuti = $cutiQuery->paginate($perPage);

        $cuti->appends(['search' => $search]);

        return view('user.simoja.koordinator.cuti.tim_index', compact('cuti'));
    }

    public function my_index_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

        $user_id = auth()->user()->id;
        $cuti = Cuti::where('user_id', $user_id)
                    ->orderBy('tanggal_awal', 'DESC')
                    ->orderBy('tanggal_akhir', 'DESC')
                    ->get();

        $konfigurasi_cuti = KonfigurasiCuti::where('jenis_cuti_id', 1)
                    ->where('user_id',auth()->user()->id)
                    ->orWhere('user_id',auth()->user()->id)
                    ->firstOrFail();

        return view('user.simoja.koordinator.cuti.my_index', compact([
            'cuti',
            'konfigurasi_cuti'
        ]));
    }

    public function create_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

        $this_year = Carbon::now()->format('Y');
        $user_id = auth()->user()->id;

        $konfigurasi_cuti = KonfigurasiCuti::where('periode', $this_year)
                        ->where('user_id', $user_id)
                        ->firstOrFail();

        $jenis_cuti = JenisCuti::all();

        return view('user.simoja.koordinator.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti'
        ]));
    }

    public function store_koordinator(Request $request)
    {
        $request->validate([
            'jenis_cuti_id' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'lampiran' => 'image',
        ], [
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh kurang dari tanggal awal.',
            'lampiran.image' => 'Lampiran harus dalam format image.',
        ]);

        $user_id = auth()->user()->id;
        $jenis_cuti_id = $request->jenis_cuti_id;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $catatan = $request->catatan;
        $lampiran = $request->lampiran;
        $status = 'Diproses';
        $seksi_id = FormasiTim::where('koordinator_id', $user_id)
                ->orWhere('anggota_id', $user_id)
                ->firstOrFail()->struktur->seksi->id;
        $approved_by_id = User::where('jabatan_id', 2)
                        ->whereHas('struktur', function($query) use ($seksi_id) {
                            $query->where('seksi_id', $seksi_id);
                        })
                        ->firstOrFail()->id;

        $known_by_id = '';
        $jabatan_id = auth()->user()->jabatan->id;

        if($jabatan_id == 4) {
            $known_by_id = $user_id;
        } else if ($jabatan_id == 5) {
            $known_by_id = FormasiTim::where('anggota_id', $user_id)->firstOrFail()->koordinator->id;
        } else {
            return back()->withError('Jabatan anda tidak bisa mengajukan cuti di sistem ini.');
        }

        $tanggalAwal = Carbon::parse($request->tanggal_awal);
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir);

        $jumlahHariCuti = 0;

        while ($tanggalAwal->lessThanOrEqualTo($tanggalAkhir)) {
            // if ($tanggalAwal->dayOfWeek != Carbon::SATURDAY && $tanggalAwal->dayOfWeek != Carbon::SUNDAY) {
            //     $jumlahHariCuti++;
            // }

            $jumlahHariCuti++;
            $tanggalAwal->addDay();
        }

        if($jenis_cuti_id == 1){
            $jumlahSisaCuti = KonfigurasiCuti::where('jenis_cuti_id', 1)
                        ->where('user_id', $user_id)
                        ->firstOrFail()->jumlah;
            if ($jumlahHariCuti > $jumlahSisaCuti){
                return back()->withError('Jumlah hari Cuti yang anda ajukan melebihi sisa Cuti yang anda miliki.');
            }
        }

        $heightPhoto = 500;

        $cuti = Cuti::create([
            'user_id' => $user_id,
            'jenis_cuti_id' => $jenis_cuti_id,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jumlah' => $jumlahHariCuti,
            'known_by_id' => $known_by_id,
            'approved_by_id' => $approved_by_id,
            'catatan' => $catatan,
            'status' => $status,
        ]);

        if ($request->hasFile('lampiran') && $lampiran != '') {
            $cuti = Cuti::findOrFail($cuti->id);

            $image = Image::make($request->file('lampiran'));

            $imageName = time().'-'.$request->file('lampiran')->getClientOriginalName();
            $detailPath = 'cuti/lampiran/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, $heightPhoto, function ($constraint) {
                $constraint->aspectRatio();
            });

            $lampiran = $image->save($destinationPath.$imageName);

            $cuti->lampiran = $detailPath.$imageName;
            $cuti->save();
        }

        $tanggal = Carbon::parse($tanggal_awal)->format('d-m-Y') . ' s/d ' . Carbon::parse($tanggal_akhir)->format('d-m-Y');
        $message = $this->send_email(auth()->user()->name, auth()->user()->jabatan->name ?? '-', auth()->user()->area->pulau->name ?? '-', $jumlahHariCuti, $tanggal, $catatan, route('cuti.approval_page'));

        return redirect()->route('simoja.koordinator.my-cuti')->withNotify('Data pengajuan cuti berhasil ditambah & ' . $message);
    }

    public function destroy_koordinator(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        if($cuti->lampiran != null)
        {
            Storage::delete($cuti->lampiran);
        }
        $cuti->forceDelete();

        return redirect()->route('simoja.koordinator.my-cuti')->withNotify('Data berhasil dihapus secara permanen!');
    }







    // PJLP
    public function my_index_pjlp(Request $request)
    {
        $user_id = auth()->user()->id;

        $jenis_cuti = JenisCuti::all();
        $jenis_cuti_id = null;
        $start_date = null;
        $end_date = null;
        $sort = 'DESC';
        $status = null;

        $perPage = $request->perPage ?? 50;

        $cuti = Cuti::where('user_id', $user_id)
                    ->orderBy('tanggal_awal', $sort)
                    ->orderBy('tanggal_akhir', $sort)
                    ->paginate($perPage);

        $konfigurasi_cuti = KonfigurasiCuti::where('periode', Carbon::now()->year)
                    ->where('jenis_cuti_id', 1)
                    ->where('user_id', $user_id)
                    ->firstOrFail();

        return view('user.simoja.pjlp.cuti.my_index', [
            'cuti' => $cuti,
            'konfigurasi_cuti' => $konfigurasi_cuti,
            'jenis_cuti' => $jenis_cuti,
            'jenis_cuti_id' => $jenis_cuti_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
            'status' => $status,
        ]);
    }

    public function create_pjlp()
    {
        $this_year = Carbon::now()->format('Y');
        $user_id = auth()->user()->id;

        $konfigurasi_cuti = KonfigurasiCuti::where('periode', $this_year)
                        ->where('user_id', $user_id)
                        ->firstOrFail();

        $jenis_cuti = JenisCuti::all();

        return view('user.simoja.pjlp.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti',
        ]));
    }

    public function store_pjlp(Request $request)
    {
        $request->validate([
            'jenis_cuti_id' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'lampiran' => 'image',
        ], [
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh kurang dari tanggal awal.',
            'lampiran.image' => 'Lampiran harus dalam format image.',
        ]);

        $user_id = auth()->user()->id;
        $jenis_cuti_id = $request->jenis_cuti_id;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $catatan = $request->catatan;
        $lampiran = $request->lampiran;
        $status = 'Diproses';
        $seksi_id = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail()->struktur->seksi->id;
        $approved_by_id = User::where('jabatan_id', 2)
                        ->whereHas('struktur', function($query) use ($seksi_id) {
                            $query->where('seksi_id', $seksi_id);
                        })
                        ->firstOrFail()->id;

        $known_by_id = '';
        $jabatan_id = auth()->user()->jabatan->id;

        if($jabatan_id == 4) {
            $known_by_id = $user_id;
        } else if ($jabatan_id == 5) {
            $known_by_id = FormasiTim::where('anggota_id', $user_id)->firstOrFail()->koordinator->id;
        } else {
            return back()->withError('Jabatan anda tidak bisa mengajukan cuti di sistem ini.');
        }

        $tanggalAwal = Carbon::parse($request->tanggal_awal);
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir);

        $jumlahHariCuti = 0;

        while ($tanggalAwal->lessThanOrEqualTo($tanggalAkhir)) {
            // if ($tanggalAwal->dayOfWeek != Carbon::SATURDAY && $tanggalAwal->dayOfWeek != Carbon::SUNDAY) {
            //     $jumlahHariCuti++;
            // }

            $jumlahHariCuti++;
            $tanggalAwal->addDay();
        }

        if($jenis_cuti_id == 1){
            $jumlahSisaCuti = KonfigurasiCuti::where('periode', Carbon::now()->year)->where('jenis_cuti_id', 1)->where('user_id', $user_id)->firstOrFail()->jumlah;
            if ($jumlahHariCuti > $jumlahSisaCuti){
                return back()->withError('Jumlah hari Cuti yang anda ajukan melebihi sisa Cuti yang anda miliki.');
            }
        }

        $heightPhoto = 500;

        $cuti = Cuti::create([
            'user_id' => $user_id,
            'jenis_cuti_id' => $jenis_cuti_id,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jumlah' => $jumlahHariCuti,
            'known_by_id' => $known_by_id,
            'approved_by_id' => $approved_by_id,
            'catatan' => $catatan,
            'status' => $status,
        ]);

        if ($request->hasFile('lampiran') && $lampiran != '') {
            $cuti = Cuti::findOrFail($cuti->id);

            $image = Image::make($request->file('lampiran'));

            $imageName = time().'-'.$request->file('lampiran')->getClientOriginalName();
            $detailPath = 'cuti/lampiran/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, $heightPhoto, function ($constraint) {
                $constraint->aspectRatio();
            });

            $lampiran = $image->save($destinationPath.$imageName);

            $cuti->lampiran = $detailPath.$imageName;
            $cuti->save();
        }

        $tanggal = Carbon::parse($tanggal_awal)->format('d-m-Y') . ' s/d ' . Carbon::parse($tanggal_akhir)->format('d-m-Y');
        $message = $this->send_email(auth()->user()->name, auth()->user()->jabatan->name ?? '-', auth()->user()->area->pulau->name ?? '-', $jumlahHariCuti, $tanggal, $catatan, route('cuti.approval_page'));

        return redirect()->route('simoja.pjlp.my-cuti')->withNotify('Data pengajuan cuti berhasil ditambah & ' . $message);
    }

    public function send_email($nama, $jabatan, $lokasi_pulau, $jumlah_hari, $tanggal, $alasan, $url)
    {
        $email_tujuan = env('EMAIL_NOTIFICATION');

        $mailData = [
            'nama' => $nama,
            'jabatan' => $jabatan,
            'lokasi_pulau' => $lokasi_pulau,
            'jumlah_hari' => $jumlah_hari,
            'tanggal' => $tanggal,
            'alasan' => $alasan,
            'url' => $url,
        ];

        Mail::to($email_tujuan)->send(new CutiMail($mailData));

        return "Email notifikasi berhasil dikirim.";
    }


    public function destroy_pjlp(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        if($cuti->lampiran != null)
        {
            Storage::delete($cuti->lampiran);
        }
        $cuti->forceDelete();

        return redirect()->route('simoja.pjlp.my-cuti')->withNotify('Data berhasil dihapus secara permanen!');
    }

    public function filter_pjlp(Request $request)
    {
        $user_id = auth()->user()->id;
        $pulau_id = null;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;
        $sort = $request->sort;
        $status = $request->status;
        $jenis_cuti_id = $request->jenis_cuti_id;

        $jenis_cuti = JenisCuti::all();

        $cuti = Cuti::query();

        // Filter by user_id
        $cuti->when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });

        // Filter by pulau_id
        $cuti->when($pulau_id, function ($query) use ($request) {
            $anggota_id = FormasiTim::where('periode', Carbon::now()->year)->whereRelation('area.pulau', 'id', '=', $request->pulau_id)->pluck('anggota_id')->toArray();
            $koordinator_id = FormasiTim::where('periode', Carbon::now()->year)->whereRelation('area.pulau', 'id', '=', $request->pulau_id)->pluck('koordinator_id')->toArray();
            $user_id = array_unique(array_merge($anggota_id, $koordinator_id));

            return $query->where(function($query) use ($user_id) {
                $query->whereIn('user_id', $user_id);
            });
        });

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $cuti->whereBetween('tanggal_awal', [$start_date, $end_date]);
        }

        // Filter by jenis_cuti_id
        $cuti->when($jenis_cuti_id, function ($query) use ($request) {
            return $query->where('jenis_cuti_id', $request->jenis_cuti_id);
        });

        // Filter by status
        $cuti->when($status, function ($query) use ($request) {
            return $query->where('status', $request->status);
        });

        // Order By
        $cuti = $cuti->orderBy('tanggal_awal', $sort)
                    ->orderBy('tanggal_akhir', $sort)
                    ->paginate();

        $konfigurasi_cuti = KonfigurasiCuti::where('periode', Carbon::now()->year)
                            ->where('jenis_cuti_id', 1)
                            ->where('user_id', $user_id)
                            ->firstOrFail();

        return view('user.simoja.pjlp.cuti.my_index', [
            'cuti' => $cuti,
            'konfigurasi_cuti' => $konfigurasi_cuti,
            'jenis_cuti' => $jenis_cuti,
            'jenis_cuti_id' => $jenis_cuti_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sort' => $sort,
            'status' => $status,
        ]);
    }
}

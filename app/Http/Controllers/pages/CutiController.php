<?php

namespace App\Http\Controllers\pages;

use App\Exports\cuti\CutiExport;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::orderBy('created_at', 'DESC')->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $seksi  = Seksi::all();
        $koordinator  = User::whereRelation('jabatan', 'id', '=', 4)->get();
        $tim = Tim::orderBy('name', 'ASC')->get();

        $pulau_id = '';
        $seksi_id = '';
        $koordinator_id = '';
        $tim_id = '';
        $status = '';
        $start_date = '';
        $end_date = '';

        return view('pages.cuti.index', compact([
            'cuti',
            'pulau',
            'seksi',
            'koordinator',
            'tim',
            'pulau_id',
            'seksi_id',
            'koordinator_id',
            'tim_id',
            'status',
            'start_date',
            'end_date',
        ]));
    }

    // public function email()
    // {
    //     $mailData = [
    //         'nama' => '$nama',
    //         'jabatan' => '$jabatan',
    //         'lokasi_pulau' => '$lokasi_pulau',
    //         'jumlah_hari' => '$jumlah_hari',
    //         'tanggal' => '$tanggal',
    //         'alasan' => '$alasan',
    //         'url' => '$url',
    //     ];
    //     return view('pages.cuti.template.email', compact('mailData'));
    // }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_cuti = KonfigurasiCuti::whereYear('periode', $this_year)
                                        ->where('user_id', auth()->user()->id)
                                        ->firstOrFail();
        $jenis_cuti = JenisCuti::all();
        return view('pages.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti',
        ]));
    }

    public function store(Request $request)
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
            return redirect()->route('cuti.index')->withError('Jabatan anda tidak bisa mengajukan cuti di sistem ini.');
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
            $jumlahSisaCuti = KonfigurasiCuti::where('jenis_cuti_id', 1)->where('user_id', $user_id)->firstOrFail()->jumlah;
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

        return redirect()->route('cuti.saya')->withNotify('Data pengajuan cuti berhasil ditambah');
    }

    public function destroy(Request $request)
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

        return redirect()->route('cuti.saya')->withNotify('Data berhasil dihapus secara permanen!');
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

        return redirect()->route('cuti.approval_page')->withNotify('Data berhasil diterima!');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        $cuti->status = 'Ditolak';
        $cuti->save();

        return redirect()->route('cuti.approval_page')->withNotify('Data berhasil ditolak!');
    }

    public function cuti_saya()
    {
        $cuti = Cuti::where('user_id',auth()->user()->id)
                    ->orderBy('tanggal_awal', 'DESC')
                    ->orderBy('tanggal_akhir', 'DESC')
                    ->get();
        $konfigurasi_cuti = KonfigurasiCuti::where('jenis_cuti_id', 1)
                            ->where('user_id',auth()->user()->id)
                            ->orWhere('user_id',auth()->user()->id)
                            ->firstOrFail();
        return view('pages.cuti.my_index', compact(['cuti', 'konfigurasi_cuti']));
    }

    public function approval_page()
    {
        $approval_cuti = Cuti::where('approved_by_id', auth()->user()->id)
                        ->where('status', 'Diproses')->get();
        return view('pages.cuti.approval', compact([
            'approval_cuti',
        ]));
    }

    public function pdf($uuid)
    {
        $cuti = Cuti::where('uuid', $uuid)->firstOrFail();
        $tanggal = ($cuti->tanggal_awal == $cuti->tanggal_akhir) ? Carbon::parse($cuti->tanggal_awal)->isoFormat('D MMMM Y') : Carbon::parse($cuti->tanggal_awal)->isoFormat('D MMMM Y') . ' s/d ' . Carbon::parse($cuti->tanggal_akhir)->isoFormat('D MMMM Y');
        $tahun = Carbon::parse($cuti->tanggal_awal)->isoFormat('Y');
        $tanggal_approve = 'Jakarta, ' . Carbon::parse($cuti->updated_at)->isoFormat('D MMMM Y');
        $pdf = Pdf::loadView('pages.cuti.export.pdf', [
            'cuti' => $cuti,
            'tanggal' => $tanggal,
            'tahun' => $tahun,
            'tanggal_approve' => $tanggal_approve,
        ]);
        return $pdf->stream(Carbon::now()->format('Ymd_') . 'Surat ' . $cuti->jenis_cuti->name . '_' . $cuti->user->name . '.pdf');
    }

    public function excel(Request $request)
    {
        $pulau_id = $request->pulau_id;
        $seksi_id = $request->seksi_id;
        $koordinator_id = $request->koordinator_id;
        $tim_id = $request->tim_id;
        $status = $request->status;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;

        $waktu = Carbon::now()->format('Ymd');

        return Excel::download(new CutiExport($pulau_id, $seksi_id, $koordinator_id, $tim_id, $status, $start_date, $end_date), $waktu . '_data cuti.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function filter(Request $request)
    {
        $pulau_id = $request->pulau_id;
        $seksi_id = $request->seksi_id;
        $koordinator_id = $request->koordinator_id;
        $tim_id = $request->tim_id;
        $status = $request->status;
        $start_date = $request->start_date;
        $end_date = $request->end_date ?? $start_date;

        $cuti = Cuti::query();

        // Filter by pulau_id
        $cuti->when($pulau_id, function ($query) use ($request) {
            return $query->whereRelation('user.area.pulau', 'id', '=', $request->pulau_id);
        });

        // Filter by seksi_id
        $cuti->when($seksi_id, function ($query) use ($request) {
            return $query->whereRelation('user.struktur.seksi', 'id', '=', $request->seksi_id);
        });

        // Filter by koordinator_id
        $cuti->when($koordinator_id, function ($query) use ($request) {
            $periode = Carbon::now()->format('Y');
            $anggota_id = FormasiTim::where('koordinator_id', $request->koordinator_id)->where('periode', $periode)->pluck('anggota_id');
            $koordinator_id = FormasiTim::where('koordinator_id', $request->koordinator_id)->where('periode', $periode)->pluck('koordinator_id');
            $users_id = $anggota_id->merge($koordinator_id);
            return $query->whereIn('user_id', $users_id);
        });

        // Filter by tim_id
        $cuti->when($tim_id, function ($query) use ($request) {
            return $query->whereRelation('user.struktur.tim', 'id', '=', $request->tim_id);
        });

        // Filter by status
        $cuti->when($status, function ($query) use ($request) {
            return $query->where('status', $request->status);
        });

        // Filter by tanggal
        if ($start_date != null and $end_date != null) {
            $cuti->when($start_date, function ($query) use ($start_date) {
                return $query->whereDate('tanggal_awal', '>=', $start_date);
            });
            $cuti->when($end_date, function ($query) use ($end_date) {
                return $query->whereDate('tanggal_akhir', '<=', $end_date);
            });
        }

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $seksi  = Seksi::all();
        $koordinator  = User::whereRelation('jabatan', 'id', '=', 4)->get();
        $tim = Tim::orderBy('name', 'ASC')->get();
        return view('pages.cuti.index', [
            'cuti' => $cuti->orderBy('tanggal_awal', 'DESC')->get(),
            'pulau' => $pulau,
            'seksi' => $seksi,
            'koordinator' => $koordinator,
            'tim' => $tim,
            'pulau_id' => $pulau_id,
            'seksi_id' => $seksi_id,
            'koordinator_id' => $koordinator_id,
            'tim_id' => $tim_id,
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }
}

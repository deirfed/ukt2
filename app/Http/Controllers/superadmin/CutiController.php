<?php

namespace App\Http\Controllers\superadmin;

use App\DataTables\CutiDataTable;
use App\DataTables\CutiPersetujuanDataTable;
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
    public function index(CutiDataTable $dataTable, Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'pulau_id' => 'nullable|exists:pulau,id',
            'jenis_cuti_id' => 'nullable|exists:jenis_cuti,id',
            'status' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $user_id = $request->user_id ?? null;
        $pulau_id = $request->pulau_id ?? null;
        $seksi_id = $request->seksi_id ?? null;
        $jenis_cuti_id = $request->jenis_cuti_id ?? null;
        $status = $request->status ?? null;
        $tim_id = $request->tim_id ?? null;

        $periode = Carbon::now()->format('Y');

        $start_date = $request->start_date ?? Carbon::createFromFormat('Y', $periode)->startOfYear()->toDateString();
        $end_date = $request->end_date ?? Carbon::createFromFormat('Y', $periode)->endOfYear()->toDateString();


        $user = User::where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->whereNot('jabatan_id', 6)
                ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $seksi  = Seksi::all();
        $jenis_cuti = JenisCuti::all();

        return $dataTable->with([
            'seksi_id' => $seksi_id,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'jenis_cuti_id' => $jenis_cuti_id,
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('superadmin.cuti.cuti.index', compact([
            'seksi',
            'user',
            'pulau',
            'jenis_cuti',
            'status',
            'seksi_id',
            'user_id',
            'pulau_id',
            'jenis_cuti_id',
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

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        if ($cuti->lampiran != null) {
            Storage::delete($cuti->lampiran);
        }
        $cuti->forceDelete();

        return redirect()->route('cuti.saya')->withNotify('Data berhasil dihapus secara permanen!');
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cuti,id',
            'no_surat' => 'required|string',
        ]);

        $cuti = Cuti::findOrFail($request->id);

        $tahun = Carbon::parse($cuti->tanggal_awal)->year; // pakai tanggal_awal

        $konfigurasi_cuti = KonfigurasiCuti::where('user_id', $cuti->user_id)
            ->where('periode', $tahun)
            ->where('jenis_cuti_id', 1) // cuti tahunan
            ->firstOrFail();

        // Hindari approve ulang
        if ($cuti->status === 'Diterima') {
            return back()->withError('Cuti ini sudah pernah disetujui.');
        }

        // Validasi sisa cuti
        if ($cuti->jenis_cuti_id == 1) {
            if ($konfigurasi_cuti->jumlah < $cuti->jumlah) {
                return back()->withError(
                    'Sisa cuti tidak mencukupi. Tersisa ' . $konfigurasi_cuti->jumlah . ' hari.'
                );
            }

            $konfigurasi_cuti->decrement('jumlah', $cuti->jumlah);
        }

        // Update status cuti
        $cuti->update([
            'status'   => 'Diterima',
            'no_surat' => $request->no_surat,
        ]);

        // Generate absensi otomatis
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        for ($date = Carbon::parse($cuti->tanggal_awal); $date->lte(Carbon::parse($cuti->tanggal_akhir)); $date->addDay()) {

            // Hindari absensi double
            $exists = Absensi::where('user_id', $cuti->user_id)
                ->whereDate('tanggal', $date->toDateString())
                ->exists();

            if (!$exists) {
                Absensi::create([
                    'user_id'          => $cuti->user_id,
                    'jenis_absensi_id' => 1,
                    'tanggal'          => $date->copy(),
                    'jam_masuk'        => $konfigurasi_absensi->jam_masuk,
                    'status_masuk'     => 'Datang tepat waktu',
                    'telat_masuk'      => 0,
                    'jam_pulang'       => $konfigurasi_absensi->jam_pulang,
                    'status_pulang'    => 'Pulang tepat waktu',
                    'cepat_pulang'     => 0,
                    'status'           => $cuti->jenis_cuti->name,
                ]);
            }
        }

        return redirect()->route('admin-cuti.approval_page')->withNotify('Cuti berhasil diterima!');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        $cuti->status = 'Ditolak';
        $cuti->save();

        return redirect()->route('admin-cuti.approval_page')->withNotify('Data berhasil ditolak!');
    }

    public function approval_page(CutiPersetujuanDataTable $dataTable)
    {
        return $dataTable->render('superadmin.cuti.cuti.approval');
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
        return view('superadmin.cuti.cuti.index', [
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

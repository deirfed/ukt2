<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\Pulau;
use App\Models\Absensi;
use App\Models\Kinerja;
use App\Models\FormasiTim;
use App\Models\JenisAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\DataTables\AbsensiDataTable;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\absensi\AbsensiExport;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index(AbsensiDataTable $dataTable, Request $request)
    {
        $tahun = $tahun ?? date('Y');

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
        ])->render('superadmin.arsipdata.absensi.index', compact([
            'user',
            'pulau',
            'user_id',
            'pulau_id',
            'start_date',
            'end_date',
            'periode',
            'tahun'
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

            if ($absen) {
                if ($absen->jam_masuk == null or $absen->jam_pulang == null) {
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
}

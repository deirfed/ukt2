<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\Pulau;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\DataTables\KinerjaDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kinerja;
use App\Models\Seksi;

class KinerjaController extends Controller
{
    public function index(KinerjaDataTable $dataTable, Request $request)
    {
        $request->validate([
            'seksi_id' => 'nullable|exists:seksi,id',
            'user_id' => 'nullable|exists:users,id',
            'pulau_id' => 'nullable|exists:pulau,id',
            'kategori_id' => 'nullable|exists:kategori,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'tahun' => 'nullable|numeric',
        ]);

        $seksi_id = $request->seksi_id ?? null;
        $user_id = $request->user_id ?? null;
        $pulau_id = $request->pulau_id ?? null;
        $kategori_id = $request->kategori_id ?? null;

        $tahun = $request->tahun ?? date('Y');

        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date);
            $endDate   = Carbon::parse($request->end_date);

            // Validasi tahun harus sesuai dengan request tahun
            if ($startDate->year != $tahun || $endDate->year != $tahun) {
                return redirect()->back()->withErrors([
                    'date' => "Tanggal yang dipilih harus berada di tahun $tahun",
                ]);
            }

            // Validasi tahun start & end harus sama
            if ($startDate->year != $endDate->year) {
                return redirect()->back()->withErrors([
                    'date' => "Tanggal awal dan tanggal akhir harus berada di tahun yang sama",
                ]);
            }

            // Validasi start <= end
            if ($startDate->gt($endDate)) {
                return redirect()->back()->withErrors([
                    'date' => "Tanggal awal tidak boleh lebih besar dari tanggal akhir",
                ]);
            }
        }

        $start_date = $request->start_date ?? Carbon::createFromFormat('Y', $tahun)->startOfYear()->toDateString();
        $end_date = $request->end_date ?? Carbon::createFromFormat('Y', $tahun)->endOfYear()->toDateString();

        $user = User::where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();
        $seksi = Seksi::all();
        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $kategori = Kategori::orderBy('seksi_id', 'asc')->get();
        $tahuns = Kinerja::selectRaw('YEAR(tanggal) as tahun')
                ->distinct()
                ->orderBy('tahun', 'asc')
                ->pluck('tahun');

        return $dataTable->with([
            'seksi_id' => $seksi_id,
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'kategori_id' => $kategori_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('superadmin.arsipdata.kinerja.index', compact([
            'user',
            'pulau',
            'seksi',
            'kategori',
            'seksi_id',
            'user_id',
            'pulau_id',
            'kategori_id',
            'start_date',
            'end_date',
            'tahuns',
            'tahun'
        ]));
    }
}

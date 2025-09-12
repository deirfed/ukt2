<?php

namespace App\Http\Controllers\superadmin;

use App\Models\User;
use App\Models\Pulau;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\DataTables\KinerjaDataTable;
use App\Http\Controllers\Controller;

class KinerjaController extends Controller
{
    public function index(KinerjaDataTable $dataTable, Request $request)
    {

        $tahun = $tahun ?? date('Y');
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
            'user_id' => $user_id,
            'pulau_id' => $pulau_id,
            'kategori_id' => $kategori_id,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ])->render('superadmin.arsipdata.kinerja.index', compact([
            'user',
            'pulau',
            'kategori',
            'user_id',
            'pulau_id',
            'kategori_id',
            'start_date',
            'end_date',
            'tahun'
        ]));
    }
}

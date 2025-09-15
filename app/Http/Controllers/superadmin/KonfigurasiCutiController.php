<?php

namespace App\Http\Controllers\superadmin;

use App\DataTables\KonfigurasiCutiDataTable;
use App\Models\User;
use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\KonfigurasiCuti;
use App\Http\Controllers\Controller;

class KonfigurasiCutiController extends Controller
{
    public function index(KonfigurasiCutiDataTable $dataTable, Request $request)
    {
        $request->validate([
            'periode' => 'nullable|numeric'
        ]);

        $periode = $request->periode ?? Carbon::now()->format('Y');

        $tahuns = KonfigurasiCuti::select('periode')
            ->distinct()
            ->orderBy('periode', 'asc')
            ->pluck('periode');

        return $dataTable->with([
            'periode' => $periode,
        ])->render('superadmin.cuti.konfigurasicuti.index', compact([
            'periode',
            'tahuns',
        ]));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $user = User::where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();
        $jenis_cuti = JenisCuti::where('id', 1)->get();

        return view('superadmin.cuti.konfigurasicuti.create', compact([
            'this_year',
            'user',
            'jenis_cuti',
        ]));
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'periode' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $user = User::findOrFail($request->user_id);

        $validate = [
            'user_id' => $request->user_id,
            'periode' => $request->periode,
        ];

        $konfigurasi_cuti = KonfigurasiCuti::updateOrCreate($validate, $rawData);

        $message = $konfigurasi_cuti->wasRecentlyCreated
            ? 'Data baru konfigurasi cuti untuk user <strong>' . e($user->name) . '</strong> di tahun ' . $request->periode .' berhasil ditambahkan!'
            : 'Data konfigurasi cuti atas user <strong>' . e($user->name) . '</strong> di tahun ' . $request->periode .' sudah ada dan berhasil diperbaharui!';

        return redirect()->route('admin-konfigurasi_cuti.index')->withNotify($message);
    }

    public function edit(string $uuid)
    {
        $konfigurasi_cuti = KonfigurasiCuti::where('uuid', $uuid)->firstOrFail();

        $start = $konfigurasi_cuti->periode;
        $end = Carbon::now()->addYear()->format('Y');

        $tahuns = range($start, $end);

        $user = User::where('employee_type_id', 3)
                ->orderBy('name', 'ASC')
                ->get();

        $jenis_cuti = JenisCuti::where('id', 1)->get();

        return view('superadmin.cuti.konfigurasicuti.edit', compact([
            'konfigurasi_cuti',
            'tahuns',
            'user',
            'jenis_cuti',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $konfigurasi_cuti = KonfigurasiCuti::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_cuti_id' => 'required|exists:jenis_cuti,id',
            'periode' => 'required|numeric',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $konfigurasi_cuti->update($rawData);

        return redirect()->route('admin-konfigurasi_cuti.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $konfigurasi_cuti = KonfigurasiCuti::findOrFail($request->id);

        $konfigurasi_cuti->delete();

        return redirect()->route('admin-konfigurasi_cuti.index')->withNotify('Data berhasil dihapus!');
    }
}

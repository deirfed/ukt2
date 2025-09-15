<?php

namespace App\Http\Controllers\superadmin;

use App\DataTables\FormasiTimDataTable;
use App\Models\Area;
use App\Models\User;
use App\Models\Struktur;
use App\Models\FormasiTim;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class FormasiTimController extends Controller
{
    public function index(FormasiTimDataTable $dataTable, Request $request)
    {
        $request->validate([
            'periode' => 'nullable|numeric'
        ]);

        $periode = $request->periode ?? Carbon::now()->format('Y');

        $tahuns = FormasiTim::select('periode')
            ->distinct()
            ->orderBy('periode', 'asc')
            ->pluck('periode');

        return $dataTable->with([
            'periode' => $periode,
        ])->render('superadmin.formasitim.index', compact([
            'periode',
            'tahuns',
        ]));
    }

    public function create()
    {
        $periode = Carbon::now()->format('Y');
        $struktur = Struktur::all();
        $area = Area::all();
        $koordinator = User::where('jabatan_id', 4)
                ->orderBy('name', 'ASC')
                ->get();

        $anggota = User::where('employee_type_id', 3) //PJLP
                // ->whereNotIn('id', function ($query) use ($periode) {
                //     $query->select('anggota_id')
                //         ->from('formasi_tim')
                //         ->where('periode', $periode);
                // })
                ->orderBy('name', 'ASC')
                ->get();

        return view('superadmin.formasitim.create', compact([
            'periode',
            'struktur',
            'area',
            'koordinator',
            'anggota',
        ]));
    }

    public function store(Request $request)
    {
        $rawData = $request->validate([
            'struktur_id' => 'required|exists:struktur,id',
            'area_id' => 'required|exists:area,id',
            'koordinator_id' => 'required|exists:users,id',
            'anggota_id' => 'required|exists:users,id',
            'periode' => 'required|numeric',
        ]);

        $user = User::findOrFail($request->anggota_id);

        $validate = [
            'anggota_id' => $request->anggota_id,
            'periode' => $request->periode,
        ];

        $formasi_tim = FormasiTim::updateOrCreate($validate, $rawData);

        // ✅ cek apakah periode ini adalah yang terbaru untuk user
        $latestPeriode = FormasiTim::where('anggota_id', $user->id)->max('periode');

        if ($request->periode == $latestPeriode) {
            $user->update([
                'area_id' => $request->area_id,
                'struktur_id' => $request->struktur_id,
            ]);
        }

        $message = $formasi_tim->wasRecentlyCreated
            ? 'Data baru formasi tim berhasil ditambahkan!'
            : 'Data formasi tim untuk user <strong>' . e($user->name) . '</strong> di tahun ' . $request->periode .' sudah ada dan berhasil diperbaharui!';

        return redirect()->route('admin-formasi_tim.index')->withNotify($message);
    }

    public function edit(string $uuid)
    {
        $formasi_tim = FormasiTim::where('uuid', $uuid)->firstOrFail();

        $start = $formasi_tim->periode;
        $end = Carbon::now()->addYear()->format('Y');

        $tahuns = range($start, $end);

        $struktur = Struktur::all();
        $area = Area::all();
        $koordinator = User::where('jabatan_id', 4)->get();
        $anggota = User::where('employee_type_id', 3)->get();

        return view('superadmin.formasitim.edit', compact([
            'formasi_tim',
            'tahuns',
            'struktur',
            'area',
            'koordinator',
            'anggota',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $formasi_tim = FormasiTim::where('uuid', $uuid)->firstOrFail();

        $rawData = $request->validate([
            'struktur_id' => 'required|exists:struktur,id',
            'area_id' => 'required|exists:area,id',
            'koordinator_id' => 'required|exists:users,id',
            'anggota_id' => 'required|exists:users,id',
            'periode' => 'required|numeric',
        ]);

        $formasi_tim->update($rawData);

        return redirect()->route('admin-formasi_tim.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $formasi_tim = FormasiTim::findOrFail($request->id);

        $formasi_tim->delete();

        return redirect()->route('admin-formasi_tim.index')->withNotify('Data berhasil dihapus!');
    }
}

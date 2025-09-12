<?php

namespace App\Http\Controllers\superadmin;

use App\Models\Area;
use App\Models\User;
use App\Models\Struktur;
use App\Models\FormasiTim;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class FormasiTimController extends Controller
{
    public function index()
    {
        $formasi_tim = FormasiTim::get();

        return view('superadmin.formasitim.index', compact(['formasi_tim']));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $struktur = Struktur::all();
        $area = Area::all();
        $koordinator = User::where('jabatan_id', 4)->get();
        $anggota = User::where('employee_type_id', 3)
            ->whereNotIn('id', function ($query) use ($this_year) {
                $query->select('anggota_id')
                    ->from('formasi_tim')
                    ->whereYear('periode', $this_year);
            })->get();

        return view('superadmin.formasitim.create', compact([
            'this_year',
            'struktur',
            'area',
            'koordinator',
            'anggota',
        ]));
    }

    public function store(Request $request)
    {
        FormasiTim::create([
            'struktur_id' => $request->struktur_id,
            'area_id' => $request->area_id,
            'koordinator_id' => $request->koordinator_id,
            'anggota_id' => $request->anggota_id,
            'periode' => $request->periode,
        ]);
        return redirect()->route('admin-formasi_tim.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit(string $uuid)
    {
        $this_year = Carbon::now()->format('Y');
        $formasi_tim = FormasiTim::where('uuid', $uuid)->first();

        if (!$formasi_tim) {
            return back()->withNotifyerror('Something went wrong!');
        }

        $struktur = Struktur::all();
        $area = Area::all();
        $koordinator = User::where('jabatan_id', 4)->get();
        $anggota = User::where('employee_type_id', 3)->get();

        return view('superadmin.formasitim.edit', compact([
            'formasi_tim',
            'this_year',
            'struktur',
            'area',
            'koordinator',
            'anggota',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $formasi_tim = FormasiTim::where('uuid', $uuid)->firstOrFail();

        $formasi_tim->update([
            'struktur_id' => $request->struktur_id,
            'area_id' => $request->area_id,
            'koordinator_id' => $request->koordinator_id,
            'anggota_id' => $request->anggota_id,
            'periode' => $request->periode,
        ]);
        return redirect()->route('admin-formasi_tim.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $formasi_tim = FormasiTim::findOrFail($request->id);

        $formasi_tim->delete();

        return redirect()->route('admin-formasi_tim.index')->withNotify('Data berhasil dihapus!');
    }
}

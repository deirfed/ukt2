<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\FormasiTim;
use App\Models\Struktur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FormasiTimController extends Controller
{
    public function index()
    {
        $this_year = Carbon::now()->format('Y');
        $formasi_tim = FormasiTim::where('periode', $this_year)->get();

        return view('admin.masterdata.data_relasi.relasi_formasi_tim.index', compact(['formasi_tim', 'this_year']));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $struktur = Struktur::all();
        $area = Area::all();
        $koordinator = User::where('employee_type_id', 2)->get();
        $anggota = User::where('employee_type_id', 3)
                        ->whereNotIn('id', function($query) use ($this_year) {
                            $query->select('anggota_id')
                                ->from('formasi_tim')
                                ->whereYear('periode', $this_year);
                        })->get();

        return view('admin.masterdata.data_relasi.relasi_formasi_tim.create', compact([
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
        return redirect()->route('formasi_tim.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $this_year = Carbon::now()->format('Y');
        $formasi_tim = FormasiTim::where('uuid', $uuid)->first();

        if(!$formasi_tim)
        {
            return back()->withNotifyerror('Something went wrong!');
        }

        $struktur = Struktur::all();
        $area = Area::all();
        $koordinator = User::where('employee_type_id', 2)->get();
        $anggota = User::where('employee_type_id', 3)->get();

        return view('admin.masterdata.data_relasi.relasi_formasi_tim.edit', compact([
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
        $formasi_tim = FormasiTim::where('uuid', $uuid)->first();

        if(!$formasi_tim)
        {
            return back()->withNotifyerror('Something went wrong!');
        }

        $formasi_tim->update([
            'struktur_id' => $request->struktur_id,
            'area_id' => $request->area_id,
            'koordinator_id' => $request->koordinator_id,
            'anggota_id' => $request->anggota_id,
            'periode' => $request->periode,
        ]);
        return redirect()->route('formasi_tim.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $formasi_tim = FormasiTim::findOrFail($request->id);
        $formasi_tim->delete();
        return redirect()->route('formasi_tim.index')->withNotify('Data berhasil dihapus!');
    }
}

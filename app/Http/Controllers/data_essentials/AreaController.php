<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Pulau;
use App\Models\Walikota;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $area = Area::orderBy('provinsi_id', 'ASC')
                        ->orderBy('walikota_id', 'ASC')
                        ->orderBy('kecamatan_id', 'ASC')
                        ->orderBy('kelurahan_id', 'ASC')
                        ->orderBy('pulau_id', 'ASC')
                        ->get();
        return view('admin.masterdata.data_relasi.relasi_area.index', compact(['area']));
    }

    public function create()
    {
        $provinsi = Provinsi::orderBy('name', 'ASC')->get();
        $walikota = Walikota::orderBy('name', 'ASC')->get();
        $kecamatan = Kecamatan::orderBy('name', 'ASC')->get();
        $kelurahan = Kelurahan::orderBy('name', 'ASC')->get();
        $pulau = Pulau::orderBy('name', 'ASC')->get();

        return view('admin.masterdata.data_relasi.relasi_area.create', compact([
            'provinsi',
            'walikota',
            'kecamatan',
            'kelurahan',
            'pulau',
        ]));
    }

    public function store(Request $request)
    {
        Area::create([
            'provinsi_id' => $request->provinsi_id,
            'walikota_id' => $request->walikota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'pulau_id' => $request->pulau_id,
        ]);
        return redirect()->route('area.index')->withNotify('Data berhasil ditambah!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $uuid)
    {
        $area = Area::where('uuid', $uuid)->first();

        if(!$area)
        {
            return back()->withNotifyerror('Something went wrong!');
        }

        $provinsi = Provinsi::orderBy('name', 'ASC')->get();
        $walikota = Walikota::orderBy('name', 'ASC')->get();
        $kecamatan = Kecamatan::orderBy('name', 'ASC')->get();
        $kelurahan = Kelurahan::orderBy('name', 'ASC')->get();
        $pulau = Pulau::orderBy('name', 'ASC')->get();

        return view('admin.masterdata.data_relasi.relasi_area.edit', compact([
            'area',
            'provinsi',
            'walikota',
            'kecamatan',
            'kelurahan',
            'pulau',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $area = Area::where('uuid', $uuid)->first();

        if(!$area)
        {
            return back()->withNotifyerror('Something went wrong!');
        }

        $area->update([
            'provinsi_id' => $request->provinsi_id,
            'walikota_id' => $request->walikota_id,
            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,
            'pulau_id' => $request->pulau_id,
        ]);

        return redirect()->route('area.index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $area = Area::findOrFail($request->id);
        $area->delete();
        return redirect()->route('area.index')->withNotify('Data berhasil dihapus!');
    }
}

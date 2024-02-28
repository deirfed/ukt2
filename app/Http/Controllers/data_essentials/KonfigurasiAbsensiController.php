<?php

namespace App\Http\Controllers\data_essentials;

use App\Http\Controllers\Controller;
use App\Models\JenisAbsensi;
use App\Models\KonfigurasiAbsensi;
use Illuminate\Http\Request;

class KonfigurasiAbsensiController extends Controller
{
    public function index()
    {
        $konfigurasi_absensi = KonfigurasiAbsensi::all();

        return view('admin.masterdata.data_relasi.relasi_konfigurasi_absensi.index', compact(['konfigurasi_absensi']));
    }

    public function create()
    {
        $jenis_absensi = JenisAbsensi::all();

        return view('admin.masterdata.data_relasi.relasi_konfigurasi_absensi.create', compact([
            'jenis_absensi',
        ]));
    }

    public function store(Request $request)
    {
        KonfigurasiAbsensi::create([
            'jenis_absensi_id' => $request->jenis_absensi_id,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'toleransi_masuk' => $request->toleransi_masuk,
            'toleransi_pulang' => $request->toleransi_pulang,
        ]);
        return redirect()->route('konfigurasi_absensi.index')->withNotify('Data berhasil ditambah!');
    }

    public function edit(string $uuid)
    {
        $konfigurasi_absensi = KonfigurasiAbsensi::where('uuid', $uuid)->firstOrFail();

        $jenis_absensi = JenisAbsensi::all();

        return view('admin.masterdata.data_relasi.relasi_konfigurasi_absensi.edit', compact([
            'konfigurasi_absensi',
            'jenis_absensi',
        ]));
    }

    public function update(Request $request, string $uuid)
    {
        $konfigurasi_absensi = KonfigurasiAbsensi::where('uuid', $uuid)->firstOrFail();

        $konfigurasi_absensi->update([
            'jenis_absensi_id' => $request->jenis_absensi_id,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'toleransi_masuk' => $request->toleransi_masuk,
            'toleransi_pulang' => $request->toleransi_pulang,
        ]);
        return redirect()->route('konfigurasi_absensi.index')->withNotify('Data berhasil diperbaharui!');
    }

    public function destroy(Request $request)
    {
        $konfigurasi_absensi = KonfigurasiAbsensi::findOrFail($request->id);
        $konfigurasi_absensi->delete();
        return redirect()->route('konfigurasi_absensi.index')->withNotify('Data berhasil dihapus!');
    }
}

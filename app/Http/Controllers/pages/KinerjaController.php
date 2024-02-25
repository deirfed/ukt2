<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\FormasiTim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KinerjaController extends Controller
{
    public function index()
    {
        return view('pages.kinerja.index');
    }

    public function create()
    {
        return view('pages.kinerja.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(string $uuid)
    {
        //
    }

    public function update(Request $request, string $uuid)
    {
        //
    }

    public function destroy(Request $request)
    {
        //
    }

    public function formasi()
    {
        $this_year = Carbon::now()->format('Y');
        $timIds = FormasiTim::where('periode', $this_year)->distinct()->pluck('struktur_id');
        $formasi_tim = [];

        foreach ($timIds as $timId) {
            $data = FormasiTim::where('periode', $this_year)->where('struktur_id', $timId)->first();
            $anggota_ids = FormasiTim::where('periode', $this_year)->where('struktur_id', $timId)->distinct()->pluck('anggota_id');
            $anggota = User::whereIn('id', $anggota_ids)->get(['name', 'photo']);

            $formasi_tim[] = [
                'tim' => $data->struktur->tim->name,
                'seksi' => $data->struktur->seksi->name,
                'koordinator' => $data->koordinator,
                'pulau' => $data->area->pulau->name,
                'anggota' => $anggota,
            ];
        }

        return view('pages.kinerja.formasi', ['formasi_tim' => $formasi_tim]);
    }
}
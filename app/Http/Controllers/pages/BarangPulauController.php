<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\BarangPulau;
use App\Models\FormasiTim;
use Illuminate\Http\Request;

class BarangPulauController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $formasi_tim = FormasiTim::where('koordinator_id', $user_id)
                        ->orWhere('anggota_id', $user_id)
                        ->first();
        $pulau_id = $formasi_tim->area->pulau->id;
        $seksi_id = $formasi_tim->struktur->seksi->id;

        $barang_pulau = BarangPulau::where('stock_aktual', '>', 0)
                        ->whereRelation('gudang.pulau', 'id', '=', $pulau_id)
                        ->whereRelation('barang.kontrak.seksi', 'id', '=', $seksi_id)
                        ->get();

        return view('pages.barang_pulau.index', compact(['barang_pulau', 'formasi_tim']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

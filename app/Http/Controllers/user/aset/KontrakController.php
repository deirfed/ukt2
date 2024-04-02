<?php

namespace App\Http\Controllers\user\aset;

use App\Models\Kontrak;
use App\Models\Seksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class KontrakController extends Controller
{
    public function index()
    {
        $kontrak = Kontrak::orderBy('name')->get();

        return view('user.aset.kasi.kontrak.index', compact(['kontrak']));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $seksi = Seksi::all();
        return view('user.aset.kasi.kontrak.create', compact(['this_year', 'seksi']));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'no_kontrak' => 'required',
                'nilai_kontrak' => 'required',
                'tanggal' => 'required',
                'seksi_id' => 'required',
                'lampiran' => 'file|mimes:pdf|max:1024',
            ],
            [
                'lampiran.max' => 'ukuran file lampiran maksimal 1 MB',
            ],
        );

        $kontrak = Kontrak::create([
            'name' => $request->name,
            'no_kontrak' => $request->no_kontrak,
            'nilai_kontrak' => $request->nilai_kontrak,
            'tanggal' => $request->tanggal,
            'seksi_id' => $request->seksi_id,
        ]);

        if ($request->hasFile('lampiran') && $request->lampiran != '') {
            $kontrak = Kontrak::findOrFail($kontrak->id);
            $lampiran = $request->file('lampiran')->store('kontrak/lampiran');
            $kontrak->update([
                'lampiran' => $lampiran,
            ]);
        }

        return redirect()->route('aset.kasi.kontrak-index')->withNotify('Data berhasil ditambah!');
    }

    public function edit($uuid)
    {
        $kontrak = Kontrak::where('uuid', $uuid)->firstOrFail();

        return view('user.aset.kasi.kontrak.edit', compact(['kontrak']));
    }

    public function update(Request $request, $id)
    {
        $kontrak = Kontrak::findOrFail($id);

        $kontrak->update([
            'name' => $request->name,
            'no_kontrak' => $request->no_kontrak,
            'nilai_kontrak' => $request->nilai_kontrak,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('aset.kasi.kontrak-index')->withNotify('Data berhasil diubah!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $kontrak = Kontrak::findOrFail($id);

        if (!$kontrak) {
            return redirect()->back();
        }
        $kontrak->delete();

        return redirect()->route('aset.kasi.kontrak-index')->withNotify('Data berhasil dihapus!');
    }
}

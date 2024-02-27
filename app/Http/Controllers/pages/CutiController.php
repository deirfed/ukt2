<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\FormasiTim;
use App\Models\JenisCuti;
use App\Models\KonfigurasiCuti;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = Cuti::all();
        $approval_cuti = Cuti::where('approved_by_id', auth()->user()->id)->get();
        return view('pages.cuti.index', compact([
            'cuti',
            'approval_cuti',
        ]));
    }

    public function create()
    {
        $this_year = Carbon::now()->format('Y');
        $konfigurasi_cuti = KonfigurasiCuti::whereYear('periode', $this_year)
                                        ->where('user_id', auth()->user()->id)
                                        ->firstOrFail();
        $jenis_cuti = JenisCuti::all();
        return view('pages.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti',
        ]));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_cuti_id' => 'required',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'lampiran' => 'image',
        ], [
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh kurang dari tanggal awal.',
            'lampiran.image' => 'Lampiran harus dalam format image.',
        ]);

        $user_id = auth()->user()->id;
        $jenis_cuti_id = $request->jenis_cuti_id;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;
        $status = 'Diproses';
        $seksi_id = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail()->struktur->seksi->id;
        $approved_by_id = User::where('jabatan_id', 2)->whereHas('struktur', function($query) use ($seksi_id) {
            $query->where('seksi_id', $seksi_id);
        })->firstOrFail()->id;

        // if(auth()->user()->jabatan->id == 5) {
        //     $approved_by_id = FormasiTim::whereYear('periode', Carbon::now()->format('Y'))
        //                         ->where('anggota_id', $user_id)
        //                         ->firstOrFail()
        //                         ->koordinator->id;
        // } elseif (auth()->user()->jabatan->id == 4) {
        //     $approved_by_id = FormasiTim::whereYear('periode', Carbon::now()->format('Y'))
        //             ->where('koordinator_id', $user_id)
        //             ->firstOrFail()
        //             ->koordinator->id;
        // } else {
        //     return back()->withError('Jabatan anda tidak bisa mengajukan cuti melalui sistem ini.');
        // }

        $tanggalAwal = Carbon::parse($request->tanggal_awal);
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir);

        $jumlahHariCuti = 0;

        while ($tanggalAwal->lessThanOrEqualTo($tanggalAkhir)) {
            if ($tanggalAwal->dayOfWeek != Carbon::SATURDAY && $tanggalAwal->dayOfWeek != Carbon::SUNDAY) {
                $jumlahHariCuti++;
            }

            $tanggalAwal->addDay();
        }
        $jumlah = $jumlahHariCuti;

        $cuti = Cuti::create([
            'user_id' => $user_id,
            'jenis_cuti_id' => $jenis_cuti_id,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jumlah' => $jumlah,
            'approved_by_id' => $approved_by_id,
            'status' => $status,
        ]);
        return redirect()->route('cuti.index')->withNotify('Data berhasil ditambah!');
    }
}

<?php

namespace App\Http\Controllers\user\simoja;

use Carbon\Carbon;
use App\Models\Cuti;
use App\Models\Kinerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\KonfigurasiCuti;
use App\Models\SuratPeringatan;

class DashboardController extends Controller
{
    public function kasi_index()
    {
        $today = Carbon::now();
        $seksi_id = auth()->user()->struktur->seksi->id;
        $tanggal = Carbon::parse($today)->isoFormat('dddd, D MMMM Y');

        $tahun = $today->format('Y');

        $jumlah_kinerja = Kinerja::where('seksi_id', $seksi_id)
                                ->whereYear('tanggal', $tahun)
                                ->count();

        $jumlah_pengajuan_cuti = Cuti::whereRelation('user.struktur.seksi', 'id', '=', $seksi_id)
                                ->where('status', 'Diproses')
                                ->whereYear('tanggal_awal', $tahun)
                                ->whereYear('tanggal_akhir', $tahun)
                                ->count();

        $data_cuti = Cuti::whereRelation('user.struktur.seksi', 'id', '=', $seksi_id)
                                ->whereYear('tanggal_awal', $tahun)
                                ->whereYear('tanggal_akhir', $tahun)
                                ->count();

        return view('user.simoja.kasi.index', compact([
            'tanggal',
            'tahun',
            'jumlah_kinerja',
            'jumlah_pengajuan_cuti',
            'data_cuti',
        ]));
    }

    public function koordinator_index()
    {
        $today = Carbon::now();
        $tanggal = Carbon::parse($today)->isoFormat('dddd, D MMMM Y');
        $jumlah_cuti = KonfigurasiCuti::where('user_id', auth()->id())->count();

        return view('user.simoja.koordinator.index', compact([
            'tanggal',
            'jumlah_cuti',
        ]));
    }

    public function pjlp_index()
    {
        $today = Carbon::now();
        $tanggal = Carbon::parse($today)->isoFormat('dddd, D MMMM Y');
        $tahun = Carbon::parse($today)->format('Y');
        $user_id = auth()->user()->id;
        $jumlah_cuti = KonfigurasiCuti::where('periode', $tahun)
                        ->where('user_id', $user_id)
                        ->first();
        $surat_peringatan = SuratPeringatan::whereYear('tanggal', $tahun)
                            ->where('user_id', $user_id)
                            ->count();


        if ($jumlah_cuti) {
            $sisa_cuti = $jumlah_cuti->jumlah;
        } else {
            $sisa_cuti = 0;
        }

        return view('user.simoja.pjlp.index', compact([
            'tanggal',
            'sisa_cuti',
            'surat_peringatan',
        ]));
    }
}

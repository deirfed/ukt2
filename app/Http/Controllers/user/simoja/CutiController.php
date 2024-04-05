<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\FormasiTim;
use App\Models\JenisCuti;
use App\Models\KonfigurasiCuti;
use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\Tim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CutiController extends Controller
{
    // KASI
    public function index()
    {
        $cuti = Cuti::whereRelation('user.struktur.seksi', 'id', '=', auth()->user()->struktur->seksi->id)
                ->orderBy('created_at', 'DESC')
                ->get();

        $pulau = Pulau::orderBy('name', 'ASC')->get();
        $seksi  = Seksi::all();
        $koordinator  = User::whereRelation('jabatan', 'id', '=', 4)->get();
        $tim = Tim::orderBy('name', 'ASC')->get();
        $konfigurasi_cuti = KonfigurasiCuti::all();

        $pulau_id = '';
        $seksi_id = '';
        $koordinator_id = '';
        $tim_id = '';
        $status = '';
        $start_date = '';
        $end_date = '';

        return view('user.simoja.kasi.cuti.index', compact([
            'cuti',
            'pulau',
            'seksi',
            'koordinator',
            'tim',
            'pulau_id',
            'seksi_id',
            'koordinator_id',
            'tim_id',
            'status',
            'start_date',
            'end_date',
            'konfigurasi_cuti'
        ]));
    }

    public function approval()
    {
        $approval_cuti = Cuti::where('approved_by_id', auth()->user()->id)
                        ->where('status', 'Diproses')->get();

        return view('user.simoja.kasi.cuti.approval', compact([
            'approval_cuti',
        ]));
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'no_surat' => 'required',
        ]);
        $cuti = Cuti::findOrFail($request->id);
        $konfigurasi_cuti = KonfigurasiCuti::where('user_id', $cuti->user_id)->firstOrFail();
        $cuti->status = 'Diterima';
        $cuti->no_surat = $request->no_surat;
        $cuti->save();

        if($cuti->jenis_cuti->id == 1){
            $konfigurasi_cuti->jumlah = $konfigurasi_cuti->jumlah - $cuti->jumlah;
            $konfigurasi_cuti->save();
        }

        return redirect()->route('simoja.kasi.cuti.approval')->withNotify('Data berhasil diterima!');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        $cuti->status = 'Ditolak';
        $cuti->save();

        return redirect()->route('simoja.kasi.cuti.approval')->withNotify('Data berhasil ditolak!');
    }






    // KOORDINATOR
    public function tim_index_koordinator()
    {
        $user_id = auth()->user()->id;
        $this_year = Carbon::now()->year;
        $anggota_id = FormasiTim::where('periode', $this_year)
                                ->where('koordinator_id', $user_id)
                                ->pluck('anggota_id')
                                ->toArray();
        $anggota_id[] = $user_id;

        $cuti = Cuti::whereIn('user_id', $anggota_id)
                        ->orderBy('tanggal_awal', 'DESC')
                        ->get();
        return view('user.simoja.koordinator.cuti.tim_index', compact([
            'cuti',
        ]));
    }

    public function my_index_koordinator()
    {
        $user_id = auth()->user()->id;
        $cuti = Cuti::where('user_id', $user_id)
                    ->orderBy('tanggal_awal', 'DESC')
                    ->orderBy('tanggal_akhir', 'DESC')
                    ->get();

        $konfigurasi_cuti = KonfigurasiCuti::where('jenis_cuti_id', 1)
                    ->where('user_id',auth()->user()->id)
                    ->orWhere('user_id',auth()->user()->id)
                    ->firstOrFail();

        return view('user.simoja.koordinator.cuti.my_index', compact([
            'cuti',
            'konfigurasi_cuti'
        ]));
    }

    public function create_koordinator()
    {
        $this_year = Carbon::now()->format('Y');
        $user_id = auth()->user()->id;

        $konfigurasi_cuti = KonfigurasiCuti::where('periode', $this_year)
                        ->where('user_id', $user_id)
                        ->firstOrFail();

        $jenis_cuti = JenisCuti::all();

        return view('user.simoja.koordinator.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti'
        ]));
    }

    public function store_koordinator(Request $request)
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
        $catatan = $request->catatan;
        $lampiran = $request->lampiran;
        $status = 'Diproses';
        $seksi_id = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail()->struktur->seksi->id;
        $approved_by_id = User::where('jabatan_id', 2)
                        ->whereHas('struktur', function($query) use ($seksi_id) {
                            $query->where('seksi_id', $seksi_id);
                        })
                        ->firstOrFail()->id;

        $known_by_id = '';
        $jabatan_id = auth()->user()->jabatan->id;

        if($jabatan_id == 4) {
            $known_by_id = $user_id;
        } else if ($jabatan_id == 5) {
            $known_by_id = FormasiTim::where('anggota_id', $user_id)->firstOrFail()->koordinator->id;
        } else {
            return back()->withError('Jabatan anda tidak bisa mengajukan cuti di sistem ini.');
        }

        $tanggalAwal = Carbon::parse($request->tanggal_awal);
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir);

        $jumlahHariCuti = 0;

        while ($tanggalAwal->lessThanOrEqualTo($tanggalAkhir)) {
            // if ($tanggalAwal->dayOfWeek != Carbon::SATURDAY && $tanggalAwal->dayOfWeek != Carbon::SUNDAY) {
            //     $jumlahHariCuti++;
            // }

            $jumlahHariCuti++;
            $tanggalAwal->addDay();
        }

        if($jenis_cuti_id == 1){
            $jumlahSisaCuti = KonfigurasiCuti::where('jenis_cuti_id', 1)->where('user_id', $user_id)->firstOrFail()->jumlah;
            if ($jumlahHariCuti > $jumlahSisaCuti){
                return back()->withError('Jumlah hari Cuti yang anda ajukan melebihi sisa Cuti yang anda miliki.');
            }
        }

        $heightPhoto = 500;

        $cuti = Cuti::create([
            'user_id' => $user_id,
            'jenis_cuti_id' => $jenis_cuti_id,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jumlah' => $jumlahHariCuti,
            'known_by_id' => $known_by_id,
            'approved_by_id' => $approved_by_id,
            'catatan' => $catatan,
            'status' => $status,
        ]);

        if ($request->hasFile('lampiran') && $lampiran != '') {
            $cuti = Cuti::findOrFail($cuti->id);

            $image = Image::make($request->file('lampiran'));

            $imageName = time().'-'.$request->file('lampiran')->getClientOriginalName();
            $detailPath = 'cuti/lampiran/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, $heightPhoto, function ($constraint) {
                $constraint->aspectRatio();
            });

            $lampiran = $image->save($destinationPath.$imageName);

            $cuti->lampiran = $detailPath.$imageName;
            $cuti->save();
        }

        return redirect()->route('simoja.koordinator.my-cuti')->withNotify('Data berhasil ditambah!');
    }

    public function destroy_koordinator(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        if($cuti->lampiran != null)
        {
            Storage::delete($cuti->lampiran);
        }
        $cuti->forceDelete();

        return redirect()->route('simoja.koordinator.my-cuti')->withNotify('Data berhasil dihapus secara permanen!');
    }







    // PJLP
    public function my_index_pjlp()
    {
        $user_id = auth()->user()->id;
        $cuti = Cuti::where('user_id', $user_id)
                    ->orderBy('tanggal_awal', 'DESC')
                    ->orderBy('tanggal_akhir', 'DESC')
                    ->get();

        $konfigurasi_cuti = KonfigurasiCuti::where('jenis_cuti_id', 1)
                    ->where('user_id',auth()->user()->id)
                    ->orWhere('user_id',auth()->user()->id)
                    ->firstOrFail();

        return view('user.simoja.pjlp.cuti.my_index', compact([
            'cuti',
            'konfigurasi_cuti',
        ]));
    }

    public function create_pjlp()
    {
        $this_year = Carbon::now()->format('Y');
        $user_id = auth()->user()->id;

        $konfigurasi_cuti = KonfigurasiCuti::where('periode', $this_year)
                        ->where('user_id', $user_id)
                        ->firstOrFail();

        $jenis_cuti = JenisCuti::all();

        return view('user.simoja.pjlp.cuti.create', compact([
            'konfigurasi_cuti',
            'jenis_cuti',
        ]));
    }

    public function store_pjlp(Request $request)
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
        $catatan = $request->catatan;
        $lampiran = $request->lampiran;
        $status = 'Diproses';
        $seksi_id = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail()->struktur->seksi->id;
        $approved_by_id = User::where('jabatan_id', 2)
                        ->whereHas('struktur', function($query) use ($seksi_id) {
                            $query->where('seksi_id', $seksi_id);
                        })
                        ->firstOrFail()->id;

        $known_by_id = '';
        $jabatan_id = auth()->user()->jabatan->id;

        if($jabatan_id == 4) {
            $known_by_id = $user_id;
        } else if ($jabatan_id == 5) {
            $known_by_id = FormasiTim::where('anggota_id', $user_id)->firstOrFail()->koordinator->id;
        } else {
            return back()->withError('Jabatan anda tidak bisa mengajukan cuti di sistem ini.');
        }

        $tanggalAwal = Carbon::parse($request->tanggal_awal);
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir);

        $jumlahHariCuti = 0;

        while ($tanggalAwal->lessThanOrEqualTo($tanggalAkhir)) {
            // if ($tanggalAwal->dayOfWeek != Carbon::SATURDAY && $tanggalAwal->dayOfWeek != Carbon::SUNDAY) {
            //     $jumlahHariCuti++;
            // }

            $jumlahHariCuti++;
            $tanggalAwal->addDay();
        }

        if($jenis_cuti_id == 1){
            $jumlahSisaCuti = KonfigurasiCuti::where('jenis_cuti_id', 1)->where('user_id', $user_id)->firstOrFail()->jumlah;
            if ($jumlahHariCuti > $jumlahSisaCuti){
                return back()->withError('Jumlah hari Cuti yang anda ajukan melebihi sisa Cuti yang anda miliki.');
            }
        }

        $heightPhoto = 500;

        $cuti = Cuti::create([
            'user_id' => $user_id,
            'jenis_cuti_id' => $jenis_cuti_id,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'jumlah' => $jumlahHariCuti,
            'known_by_id' => $known_by_id,
            'approved_by_id' => $approved_by_id,
            'catatan' => $catatan,
            'status' => $status,
        ]);

        if ($request->hasFile('lampiran') && $lampiran != '') {
            $cuti = Cuti::findOrFail($cuti->id);

            $image = Image::make($request->file('lampiran'));

            $imageName = time().'-'.$request->file('lampiran')->getClientOriginalName();
            $detailPath = 'cuti/lampiran/';
            $destinationPath = public_path('storage/'. $detailPath);

            $image->resize(null, $heightPhoto, function ($constraint) {
                $constraint->aspectRatio();
            });

            $lampiran = $image->save($destinationPath.$imageName);

            $cuti->lampiran = $detailPath.$imageName;
            $cuti->save();
        }

        return redirect()->route('simoja.pjlp.my-cuti')->withNotify('Data berhasil ditambah!');
    }

    public function destroy_pjlp(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $cuti = Cuti::findOrFail($request->id);
        if($cuti->lampiran != null)
        {
            Storage::delete($cuti->lampiran);
        }
        $cuti->forceDelete();

        return redirect()->route('simoja.pjlp.my-cuti')->withNotify('Data berhasil dihapus secara permanen!');
    }
}

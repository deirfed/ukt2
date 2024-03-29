<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JenisAbsensi;
use App\Models\KonfigurasiAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    // KASI
    public function index_kasi()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $absensi = Absensi::whereRelation('user.struktur.seksi', 'id', '=', $seksi_id)
                            ->orderBy('tanggal', 'DESC')
                            ->get();
        return view('user.simoja.kasi.absensi.index', compact([
            'absensi',
        ]));
    }

    // KOORDINATOR
    public function tim_index_koordinator()
    {
        return view('user.simoja.koordinator.absensi.tim_index');
    }

    public function my_index_koordinator()
    {
        return view('user.simoja.koordinator.absensi.my_index');
    }

    public function create_koordinator()
    {
        return view('user.simoja.koordinator.absensi.create');
    }

    // PJLP
    public function my_index_pjlp()
    {
        $user_id = auth()->user()->id;
        $absensi = Absensi::where('user_id', $user_id)->orderBy('tanggal', 'DESC')->get();
        return view('user.simoja.pjlp.absensi.my_index', compact([
            'absensi',
        ]));
    }

    public function create_pjlp()
    {
        $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenis_absensi = JenisAbsensi::findOrFail(1);
        return view('user.simoja.pjlp.absensi.create', compact([
            'jenis_absensi',
            'tanggal',
        ]));
    }

    public function store_pjlp(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $img = $request->photo;
        $folderPath = "absensi/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        $now = Carbon::now();
        $tanggal = Carbon::parse($now)->format('Y-m-d');
        $waktu = Carbon::parse($now);
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $jam_masuk = Carbon::parse($konfigurasi_absensi->jam_masuk);
        $jam_pulang = Carbon::parse($konfigurasi_absensi->jam_pulang);

        $user_id = auth()->user()->id;
        $latitude = 'xxx';
        $longitude = 'xxx';

        if($waktu >= Carbon::parse('01:00:00') and $waktu <= Carbon::parse('02:00:00')) {
            $validasi = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan Absen Masuk hari ini.');
            }

            $status = 'Absen Masuk';

            if($waktu > $jam_masuk) {
                $status_absen = 'Terlambat Masuk';
                $telat = $waktu->diffInMinutes($jam_masuk);
            } else {
                $status_absen = 'Tepat Waktu';
                $telat = 0;
            }
        } elseif($waktu > Carbon::parse('02:00:00') and $waktu <= Carbon::parse('22:00:00')) {
            $validasi = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan Absen Pulang hari ini.');
            }

            $status = 'Absen Pulang';

            if($waktu < $jam_pulang) {
                $status_absen = 'Pulang Cepat';
                $telat = $waktu->diffInMinutes($jam_pulang);
            } else {
                $status_absen = 'Tepat Waktu';
                $telat = 0;
            }
        } else {
            return back()->withError('Anda tidak bisa melakukan absensi di waktu saat ini.');
        }

        $validasiTanggal = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
        if($validasiTanggal == 0) {
            Absensi::create([
                'jenis_absensi_id' => 1,
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'jam_masuk' => $waktu,
                'telat_masuk' => $telat,
                'photo_masuk' => $file,
                'latitude_masuk' => $latitude,
                'longitude_masuk' => $longitude,
                'status_masuk' => $status_absen,
                'status'=> $status,
            ]);
        } else {
            $absensi =Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->first();
            if($absensi->jam_pulang != null) {
                return back()->withNotify('Anda sudah absen hari ini.');
            }
            $absensi->update([
                'jam_pulang' => $waktu,
                'cepat_pulang' => $telat,
                'photo_pulang' => $file,
                'latitude_pulang' => $latitude,
                'longitude_pulang' => $longitude,
                'status_pulang' => $status_absen,
                'status'=> $status,
            ]);
        }

        return redirect()->route('simoja.pjlp.my-absensi')->withNotify('Data ' . $status . ' Berhasil Disimpan!');
    }
}

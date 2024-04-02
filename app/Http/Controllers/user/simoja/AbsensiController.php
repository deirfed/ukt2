<?php

namespace App\Http\Controllers\user\simoja;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\FormasiTim;
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
        $user_id = auth()->user()->id;
        $this_year = Carbon::now()->year;
        $anggota_id = FormasiTim::where('periode', $this_year)
                                ->where('koordinator_id', $user_id)
                                ->pluck('anggota_id')
                                ->toArray();
        $anggota_id[] = $user_id;

        $absensi = Absensi::whereIn('user_id', $anggota_id)
                        ->orderBy('tanggal', 'DESC')
                        ->get();

        return view('user.simoja.koordinator.absensi.tim_index', compact([
            'absensi'
        ]));
    }

    public function my_index_koordinator()
    {
        $user_id = auth()->user()->id;
        $absensi = Absensi::where('user_id', $user_id)->orderBy('tanggal', 'DESC')->get();
        return view('user.simoja.koordinator.absensi.my_index', compact([
            'absensi'
        ]));
    }

    public function create_koordinator()
    {
        $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $jenis_absensi = JenisAbsensi::findOrFail(1);
        return view('user.simoja.koordinator.absensi.create', compact([
            'tanggal',
            'jenis_absensi',
        ]));
    }

    public function store_koordinator(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $img = $request->photo;

        $now = Carbon::now();
        $tanggal = Carbon::parse($now)->format('Y-m-d');
        $waktu = Carbon::parse($now);
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $jam_masuk = Carbon::parse($konfigurasi_absensi->jam_masuk);
        $jam_pulang = Carbon::parse($konfigurasi_absensi->jam_pulang);

        $user_id = auth()->user()->id;
        $latitude = 'xxx';
        $longitude = 'xxx';
        $batas_mulai_absen_masuk = '05:00:00';
        $batas_selesai_absen_masuk = '12:00:00';
        $batas_mulai_absen_pulang = '12:00:00';
        $batas_selesai_absen_pulang = '22:00:00';

        if($waktu >= Carbon::parse($batas_mulai_absen_masuk) and $waktu <= Carbon::parse($batas_selesai_absen_masuk)) {
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
        } elseif($waktu > Carbon::parse($batas_mulai_absen_pulang) and $waktu <= Carbon::parse($batas_selesai_absen_pulang)) {
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

        $folderPath = "absensi/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;

        Storage::put($file, $image_base64);

        $validasiTanggal = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
        if($validasiTanggal == 0 and $status == 'Absen Masuk') {
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
            if ($absensi){
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
            } else {
                Absensi::create([
                    'jenis_absensi_id' => 1,
                    'user_id' => $user_id,
                    'tanggal' => $tanggal,
                    'status_masuk' => 'Tidak Absen Masuk',
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'photo_pulang' => $file,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absen,
                    'status'=> 'Tidak Absen Masuk',
                ]);
                return redirect()->route('simoja.koordinator.my-absensi')->withNotify('Anda tidak melakukan Absen Masuk di waktu yang ditentukan, data ini disimpan Absen Pulang!');
            }
        }

        return redirect()->route('simoja.koordinator.my-absensi')->withNotify('Data ' . $status . ' Berhasil Disimpan!');
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

        $now = Carbon::now();
        $tanggal = Carbon::parse($now)->format('Y-m-d');
        $waktu = Carbon::parse($now);
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $jam_masuk = Carbon::parse($konfigurasi_absensi->jam_masuk);
        $jam_pulang = Carbon::parse($konfigurasi_absensi->jam_pulang);

        $user_id = auth()->user()->id;
        $latitude = 'xxx';
        $longitude = 'xxx';
        $batas_mulai_absen_masuk = '05:00:00';
        $batas_selesai_absen_masuk = '12:00:00';
        $batas_mulai_absen_pulang = '12:00:00';
        $batas_selesai_absen_pulang = '22:00:00';

        if($waktu >= Carbon::parse($batas_mulai_absen_masuk) and $waktu <= Carbon::parse($batas_selesai_absen_masuk)) {
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
        } elseif($waktu > Carbon::parse($batas_mulai_absen_pulang) and $waktu <= Carbon::parse($batas_selesai_absen_pulang)) {
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

        $folderPath = "absensi/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;

        Storage::put($file, $image_base64);

        $validasiTanggal = Absensi::where('user_id', $user_id)->whereDate('tanggal', $tanggal)->count();
        if($validasiTanggal == 0 and $status == 'Absen Masuk') {
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
            if ($absensi){
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
            } else {
                Absensi::create([
                    'jenis_absensi_id' => 1,
                    'user_id' => $user_id,
                    'tanggal' => $tanggal,
                    'status_masuk' => 'Tidak Absen Masuk',
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'photo_pulang' => $file,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absen,
                    'status'=> 'Tidak Absen Masuk',
                ]);
                return redirect()->route('simoja.pjlp.my-absensi')->withNotify('Anda tidak melakukan Absen Masuk di waktu yang ditentukan, data ini disimpan Absen Pulang!');
            }
        }

        return redirect()->route('simoja.pjlp.my-absensi')->withNotify('Data ' . $status . ' Berhasil Disimpan!');
    }
}

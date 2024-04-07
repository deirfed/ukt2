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
use Intervention\Image\Facades\Image;

class AbsensiController extends Controller
{
    // KASI
    public function index_kasi()
    {
        $seksi_id = auth()->user()->struktur->seksi->id;
        $absensi = Absensi::whereRelation('user.struktur.seksi', 'id', '=', $seksi_id)
                            ->orderBy('tanggal', 'DESC')
                            ->orderBy('jam_masuk', 'DESC')
                            ->orderBy('jam_pulang', 'DESC')
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
                        ->orderBy('jam_masuk', 'DESC')
                        ->orderBy('jam_pulang', 'DESC')
                        ->get();

        return view('user.simoja.koordinator.absensi.tim_index', compact([
            'absensi'
        ]));
    }

    public function my_index_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

        $user_id = auth()->user()->id;
        $absensi = Absensi::where('user_id', $user_id)
                    ->orderBy('tanggal', 'DESC')
                    ->orderBy('jam_masuk', 'DESC')
                    ->orderBy('jam_pulang', 'DESC')
                    ->get();
        return view('user.simoja.koordinator.absensi.my_index', compact([
            'absensi'
        ]));
    }

    public function create_koordinator()
    {
        $isPNS = auth()->user()->employee_type->id;
        if($isPNS == 1) {
            return back()->withError('Anda PNS, Fitur ini hanya untuk Koordinator PJLP & PJLP!');
        }

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
        $absensi = Absensi::where('user_id', $user_id)
                        ->orderBy('tanggal', 'DESC')
                        ->orderBy('jam_masuk', 'DESC')
                        ->orderBy('jam_pulang', 'DESC')
                        ->get();
        return view('user.simoja.pjlp.absensi.my_index', compact([
            'absensi',
        ]));
    }

    public function create_pjlp()
    {
        $tanggal = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $now = Carbon::now();
        $waktu = Carbon::parse($now);
        $jenis_absensi = JenisAbsensi::findOrFail(1);
        $user_id = auth()->user()->id;
        $formasi_tim = FormasiTim::where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->firstOrFail();

        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $batas_mulai_absen_masuk = Carbon::parse($konfigurasi_absensi->mulai_absen_masuk);
        $batas_selesai_absen_masuk = Carbon::parse($konfigurasi_absensi->selesai_absen_masuk);
        $batas_mulai_absen_pulang = Carbon::parse($konfigurasi_absensi->mulai_absen_pulang);
        $batas_selesai_absen_pulang = Carbon::parse($konfigurasi_absensi->selesai_absen_pulang);

        if($waktu >= $batas_mulai_absen_masuk and $waktu <= $batas_selesai_absen_masuk) {
            $mode = 'Absensi Datang';
        }
        elseif($waktu >= $batas_mulai_absen_pulang and $waktu <= $batas_selesai_absen_pulang) {
            $mode = 'Absensi Pulang';
        }
        else {
            $mode = 'Sekarang bukan waktu untuk Absensi';
        }

        return view('user.simoja.pjlp.absensi.create', compact([
            'jenis_absensi',
            'tanggal',
            'mode',
            'formasi_tim',
        ]));
    }

    public function store_pjlp(Request $request)
    {
        $request->validate([
            'photo' => 'required'
        ]);

        $img = $request->photo;
        $catatan = $request->catatan;

        $now = Carbon::now();
        $tanggal = Carbon::parse($now)->format('Y-m-d');
        $waktu = Carbon::parse($now);
        $konfigurasi_absensi = KonfigurasiAbsensi::where('jenis_absensi_id', 1)->first();
        $jam_masuk = Carbon::parse($konfigurasi_absensi->jam_masuk);
        $jam_pulang = Carbon::parse($konfigurasi_absensi->jam_pulang);

        $user_id = auth()->user()->id;
        $latitude = 'xxx';
        $longitude = 'xxx';

        $mode = '';
        $telat = '';
        $status_absensi = '';

        $batas_mulai_absen_masuk = Carbon::parse($konfigurasi_absensi->mulai_absen_masuk);
        $batas_selesai_absen_masuk = Carbon::parse($konfigurasi_absensi->selesai_absen_masuk);
        $batas_mulai_absen_pulang = Carbon::parse($konfigurasi_absensi->mulai_absen_pulang);
        $batas_selesai_absen_pulang = Carbon::parse($konfigurasi_absensi->selesai_absen_pulang);

        $hari = Carbon::parse($waktu)->isoFormat('dddd');
        if($hari == 'Jumat'){
            $jam_pulang = Carbon::parse('16:30:00');
            $batas_mulai_absen_pulang = Carbon::parse('16:30:00');
        }

        $formasi = FormasiTim::where('periode', Carbon::now()->year)->where('koordinator_id', $user_id)->orWhere('anggota_id', $user_id)->first();
        $nama = strtoupper($formasi->anggota->name) . ' - ' . $formasi->anggota->nip;
        $jam = Carbon::parse($waktu)->format('H:i:s') . ' WIB';
        $date = Carbon::parse($waktu)->isoFormat('dddd, D MMMM Y') . ' - ' . $jam;
        $seksi = 'Seksi ' . $formasi->struktur->seksi->name;
        $pulau = 'Pulau ' . $formasi->area->pulau->name;

        if($waktu >= $batas_mulai_absen_masuk and $waktu <= $batas_selesai_absen_masuk) {
            $mode = 'Absensi Datang';
            if ($waktu > $jam_masuk){
                $telat = $waktu->diffInMinutes($jam_masuk);
                $status_absensi = 'Datang terlambat';

            } else {
                $telat = 0;
                $status_absensi = 'Datang tepat waktu';
            }
        }
        elseif($waktu >= $batas_mulai_absen_pulang and $waktu <= $batas_selesai_absen_pulang) {
            $mode = 'Absensi Pulang';
            if ($waktu < $jam_pulang){
                $telat = $waktu->diffInMinutes($jam_pulang);
                $status_absensi = 'Pulang Cepat';

            } else {
                $telat = 0;
                $status_absensi = 'Pulang tepat waktu';
            }
        }
        else {
            return back()->withError('Anda harus melakukan absensi, pada rentan Waktu yang telah ditentukan!');
        }

        if ($mode == 'Absensi Datang') {
            $validasi = Absensi::where('user_id', $user_id)
                        ->whereDate('tanggal', $tanggal)
                        ->where('jam_masuk', '!=', null)
                        ->count();

            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan ' . $mode . ' hari ini.');
            }

            $absensi = Absensi::create([
                'jenis_absensi_id' => 1,
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'jam_masuk' => $waktu,
                'telat_masuk' => $telat,
                'latitude_masuk' => $latitude,
                'longitude_masuk' => $longitude,
                'status_masuk' => $status_absensi,
                'status' => $mode,
                'catatan_masuk' => $catatan,
            ]);
        } else {
            $validasi = Absensi::where('user_id', $user_id)
                        ->whereDate('tanggal', $tanggal)
                        ->where('jam_pulang', '!=', null)
                        ->count();

            if($validasi > 0) {
                return back()->withError('Anda sudah melakukan ' . $mode . ' hari ini.');
            } else {
                $mode = 'Absensi Pulang';
            }

            $absensi = Absensi::where('user_id', $user_id)
                            ->whereDate('tanggal', $tanggal)
                            ->first();

            if($absensi) {
                $absensi->update([
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absensi,
                    'status'=> $mode,
                    'catatan_pulang' => $catatan,
                ]);
            } else {
                $absensi = Absensi::create([
                    'jenis_absensi_id' => 1,
                    'user_id' => $user_id,
                    'tanggal' => $tanggal,
                    'jam_pulang' => $waktu,
                    'cepat_pulang' => $telat,
                    'latitude_pulang' => $latitude,
                    'longitude_pulang' => $longitude,
                    'status_pulang' => $status_absensi,
                    'status'=> 'Tidak Absen Datang',
                    'catatan_pulang' => $catatan,
                ]);
            }
        }

        $folderPath = "absensi/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;

        Storage::put($file, $image_base64);

        $absen = Absensi::find($absensi->id);



        if ($mode == 'Absensi Pulang') {
            $absen->update([
                'photo_pulang' => $file,
            ]);

            $path = public_path('storage/'. $absen->photo_pulang);
            $pathWatermark = public_path('assets/img/watermark.png');
            $imageName = basename($path);
            $image = Image::make($path);

            $image->insert($pathWatermark, 'bottom-center', 0, 0);
            $image->text($nama, 150, 245, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(13);
            });
            $image->text($mode, 150, 260, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($date, 150, 270, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($seksi, 150, 280, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($pulau, 150, 290, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });

            $destinationPath = public_path('storage/'. $folderPath);

            $image->save($destinationPath.$imageName);

            $message = 'Data absensi berhasil disimpan!';
        } else {
            $absen->update([
                'photo_masuk' => $file,
            ]);

            $path = public_path('storage/'. $absen->photo_masuk);
            $pathWatermark = public_path('assets/img/watermark.png');
            $imageName = basename($path);
            $image = Image::make($path);

            $image->insert($pathWatermark, 'bottom-center', 0, 0);
            $image->text($nama, 150, 245, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(13);
            });
            $image->text($mode, 150, 260, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($date, 150, 270, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($seksi, 150, 280, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });
            $image->text($pulau, 150, 290, function($font) {
                $font->file(public_path('assets/fonts/Roboto-Regular.ttf'));
                $font->color('#000000');
                $font->align('center');
                $font->valign('bottom');
                $font->size(10);
            });

            $destinationPath = public_path('storage/'. $folderPath);

            $image->save($destinationPath.$imageName);

            $message = 'Data absensi berhasil disimpan!';
        }

        return redirect()->route('simoja.pjlp.my-absensi')->withNotify($message);
    }
}

<?php

namespace App\Http\Controllers\pages;

use App\Models\User;
use App\Models\Absensi;
use App\Models\JenisAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index()
    {
        $absensi = Absensi::where('user_id', auth()->user()->id)
            ->orderBy('tanggal', 'DESC')
            ->get();
        return view('pages.absensi.index', compact(['absensi']));
    }

    public function my_index()
    {
        $absensi = Absensi::where('user_id', auth()->user()->id)
            ->orderBy('tanggal', 'DESC')
            ->get();
        return view('pages.absensi.my_index', compact(['absensi']));
    }

    public function create()
    {
        $jenis_absensi = JenisAbsensi::all();
        return view('pages.absensi.create', compact(['jenis_absensi']));
    }

    public function store(Request $request)
    {
        // dd($request);
        $img = $request->photo;
        $folderPath = "absensi/contoh/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.' . $image_type;

        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);

        dd('Image uploaded successfully: ' . $fileName);
    }

    public function admin_absensi()
    {
        $tahun = $tahun ?? date('Y');

        return view('pages.absensi.admin', compact('tahun'));
    }

    public function getDataAbsensi(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $sudahAbsen = Absensi::whereDate('tanggal', $tanggal)
            ->whereNotNull('jam_masuk')
            ->whereNotNull('jam_pulang')
            ->count();

        $totalUser = User::where('employee_type_id', 3)->count();

        $belumAbsen = $totalUser - $sudahAbsen;

        return response()->json([
            'tanggal'    => $tanggal,
            'sudahAbsen' => $sudahAbsen,
            'belumAbsen' => $belumAbsen,
            'totalUser'  => $totalUser
        ]);
    }

    public function getUsers()
    {
        $users = User::where('employee_type_id', 3)->get(['id', 'name']);
        return response()->json($users);
    }
}

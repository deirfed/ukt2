<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JenisAbsensi;
use Illuminate\Http\Request;
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

        dd('Image uploaded successfully: '.$fileName);
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
}

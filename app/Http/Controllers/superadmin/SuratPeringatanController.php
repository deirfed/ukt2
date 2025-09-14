<?php

namespace App\Http\Controllers\superadmin;

use App\DataTables\SuratPeringatanDataTable;
use App\Http\Controllers\Controller;
use App\Models\SuratPeringatan;
use App\Models\User;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratPeringatanController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index(SuratPeringatanDataTable $dataTable, Request $request)
    {
        // return view('superadmin.suratperingatan.index');
        return $dataTable->render('superadmin.suratperingatan.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();
        $rawData = $request->validate([
            "jenis" => "required|string",
            "tanggal" => "required|date",
            "alasan" => "required|string",
            "sanksi" => "required|string",
        ]);

        $request->validate([
            'file' => 'required|file|mimes:pdf|max:5048',
        ]);

        $rawData['user_id'] = $user->id;

        $validate = SuratPeringatan::where('user_id', $user->id)
                    ->whereYear('tanggal', Carbon::now()->format('Y'))
                    ->count();

        if($validate >= 3) {
            return redirect()->route('admin-user.index')->withError('Data Surat Peringatan atas nama ' . $user->name . ', sudah berjumlah ' . $validate);
        }

        $data = SuratPeringatan::updateOrCreate($rawData, $rawData);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = 'surat-peringatan/';
            $filePath = $this->fileUploadService->uploadFile($file, $path);

            // Update file path in to the database
            $data->update(['dokumen' => $filePath]);
        }

        return redirect()->route('admin-user.index')->withNotify('Data Surat Peringatan atas nama ' . $user->name . ' berhasil ditambahkan!');
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

    public function destroy(string $uuid)
    {
        $data = SuratPeringatan::where('uuid', $uuid)->firstOrFail();

        if ($data->photo_after) {
            Storage::delete($data->dokumen);
        }

        $data->forceDelete();

        return redirect()->route('admin.surat-peringatan.index')->withNotify('Surat Peringatan untuk <strong>' . $data->user->name . '</strong> berhasil dihapus permanen!');
    }
}

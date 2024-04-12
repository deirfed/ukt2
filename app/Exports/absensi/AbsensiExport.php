<?php

namespace App\Exports\absensi;

use App\Models\Absensi;
use App\Models\FormasiTim;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AbsensiExport implements FromView, ShouldAutoSize
{
    public $seksi_id;
    public $user_id;
    public $pulau_id;
    public $start_date;
    public $end_date;
    public $sort;

    public function __construct(?int $seksi_id = null, ?int $user_id = null, ?int $pulau_id = null, ?string $start_date = null, ?string $end_date = null, ?string $sort = null)
    {
        $this->seksi_id = $seksi_id;
        $this->user_id = $user_id;
        $this->pulau_id = $pulau_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->sort = $sort;
    }


    public function view(): View
    {
        $absensi = Absensi::query();

        $absensi->whereRelation('user.struktur.seksi', 'id', '=', $this->seksi_id);

        // Filter by user_id
        $absensi->when($this->user_id, function ($query) {
            return $query->where('user_id', $this->user_id);
        });

        // Filter by pulau_id
        $absensi->when($this->pulau_id, function ($query) {
            $user_id[] = FormasiTim::whereRelation('area.pulau', 'id', '=', $this->pulau_id)->pluck('anggota_id')->toArray();
            $user_id[] = FormasiTim::whereRelation('area.pulau', 'id', '=', $this->pulau_id)->pluck('koordinator_id')->toArray();
            $user_id = array_merge(...$user_id);
            return $query->whereIn('user_id', $user_id);
        });

        // Filter by tanggal
        if ($this->start_date != null and $this->end_date != null) {
            $absensi->when($this->start_date, function ($query) {
                return $query->whereDate('tanggal', '>=', $this->start_date);
            });
            $absensi->when($this->end_date, function ($query) {
                return $query->whereDate('tanggal', '<=', $this->end_date);
            });
        }

        // Order By
        $absensi = $absensi->orderBy('tanggal', $this->sort)
                        ->orderBy('jam_masuk', $this->sort)
                        ->orderBy('jam_pulang', $this->sort)
                        ->get();

        return view('user.simoja.kasi.absensi.export.excel', [
            'absensi' => $absensi,
        ]);
    }
}

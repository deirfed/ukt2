<?php

namespace App\Exports\cuti;

use App\Models\Cuti;
use App\Models\FormasiTim;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CutiExport implements FromView, ShouldAutoSize
{
    public $pulau_id;
    public $seksi_id;
    public $koordinator_id;
    public $tim_id;
    public $status;
    public $start_date;
    public $end_date;
    public function __construct(?int $pulau_id = null, ?int $seksi_id = null, ?int $koordinator_id = null, ?int $tim_id, ?string $status = null, ?string $start_date = null, ?string $end_date = null)
    {
        $this->pulau_id = $pulau_id;
        $this->seksi_id = $seksi_id;
        $this->koordinator_id = $koordinator_id;
        $this->tim_id = $tim_id;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function view(): View
    {
        $cuti = Cuti::query();

        // Filter by pulau_id
        $cuti->when($this->pulau_id, function ($query) {
            return $query->whereRelation('user.area.pulau', 'id', '=', $this->pulau_id);
        });

        // Filter by seksi_id
        $cuti->when($this->seksi_id, function ($query) {
            return $query->whereRelation('user.struktur.seksi', 'id', '=', $this->seksi_id);
        });

        // Filter by koordinator_id
        $cuti->when($this->koordinator_id, function ($query) {
            $periode = Carbon::now()->format('Y');
            $anggota_id = FormasiTim::where('koordinator_id', $this->koordinator_id)->where('periode', $periode)->pluck('anggota_id');
            $koordinator_id = FormasiTim::where('koordinator_id', $this->koordinator_id)->where('periode', $periode)->pluck('koordinator_id');
            $users_id = $anggota_id->merge($koordinator_id);
            return $query->whereIn('user_id', $users_id);
        });

        // Filter by tim_id
        $cuti->when($this->tim_id, function ($query) {
            return $query->whereRelation('user.struktur.tim', 'id', '=', $this->tim_id);
        });

        // Filter by status
        $cuti->when($this->status, function ($query) {
            return $query->where('status', $this->status);
        });

        // Filter by tanggal
        if ($this->start_date != null and $this->end_date != null) {
            $cuti->when($this->start_date, function ($query) {
                return $query->whereDate('tanggal_awal', '>=', $this->start_date);
            });
            $cuti->when($this->end_date, function ($query) {
                return $query->whereDate('tanggal_akhir', '<=', $this->end_date);
            });
        }

        return view('pages.cuti.export.excel', [
            'cuti' => $cuti->orderBy('tanggal_awal', 'ASC')->get(),
        ]);
    }
}
<?php

namespace App\Exports\cuti\user;

use App\Models\Cuti;
use App\Models\FormasiTim;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CutiExport implements FromView, ShouldAutoSize
{
    public $seksi_id;
    public $user_id;
    public $pulau_id;
    public $start_date;
    public $end_date;
    public $sort;
    public $status;
    public $jenis_cuti_id;

    public function __construct(?int $seksi_id = null, ?int $user_id = null, ?int $pulau_id = null, ?string $start_date = null, ?string $end_date = null, ?string $sort = null, ?string $status, ?int $jenis_cuti_id)
    {
        $this->seksi_id = $seksi_id;
        $this->user_id = $user_id;
        $this->pulau_id = $pulau_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->sort = $sort;
        $this->status = $status;
        $this->jenis_cuti_id = $jenis_cuti_id;
    }

    public function view(): View
    {
        $cuti = Cuti::query();

        $cuti->whereRelation('user.struktur.seksi', 'id', '=', $this->seksi_id);

        // Filter by user_id
        $cuti->when($this->user_id, function ($query) {
            return $query->where('user_id', $this->user_id);
        });

        // Filter by pulau_id
        $cuti->when($this->pulau_id, function ($query) {
            $user_id[] = FormasiTim::whereRelation('area.pulau', 'id', '=', $this->pulau_id)->pluck('anggota_id')->toArray();
            $user_id[] = FormasiTim::whereRelation('area.pulau', 'id', '=', $this->pulau_id)->pluck('koordinator_id')->toArray();
            $user_id = array_merge(...$user_id);
            return $query->whereIn('user_id', $user_id);
        });

        // Filter by tanggal
        if ($this->start_date != null and $this->end_date != null) {
            $cuti->when($this->start_date, function ($query) {
                return $query->whereDate('tanggal', '>=', $this->start_date);
            });
            $cuti->when($this->end_date, function ($query) {
                return $query->whereDate('tanggal', '<=', $this->end_date);
            });
        }

        // Filter by status
        $cuti->when($this->status, function ($query) {
            return $query->where('status', $this->status);
        });

        // Filter by jenis_cuti_id
        $cuti->when($this->jenis_cuti_id, function ($query) {
            return $query->where('jenis_cuti_id', $this->jenis_cuti_id);
        });

        // Order By
        $cuti = $cuti->orderBy('tanggal_awal', $this->sort)
                        ->orderBy('tanggal_akhir', $this->sort)
                        ->get();

        return view('user.simoja.kasi.cuti.export.excel', [
            'cuti' => $cuti,
        ]);
    }
}

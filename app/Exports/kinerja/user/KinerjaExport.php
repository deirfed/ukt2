<?php

namespace App\Exports\kinerja\user;

use App\Models\FormasiTim;
use App\Models\Kinerja;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KinerjaExport implements FromView, ShouldAutoSize
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
        $kinerja = Kinerja::query();

        $kinerja->where('seksi_id', $this->seksi_id);

        // Filter by user_id
        $kinerja->when($this->user_id, function ($query) {
            return $query->where('anggota_id', $this->user_id)->orWhere('koordinator_id', $this->user_id);
        });

        // Filter by pulau_id
        $kinerja->when($this->pulau_id, function ($query) {
            $anggota_id = FormasiTim::where('periode', Carbon::now()->year)->whereRelation('area.pulau', 'id', '=', $this->pulau_id)->pluck('anggota_id')->toArray();
            $koordinator_id = FormasiTim::where('periode', Carbon::now()->year)->whereRelation('area.pulau', 'id', '=', $this->pulau_id)->pluck('koordinator_id')->toArray();
            $user_id = array_unique(array_merge($anggota_id, $koordinator_id));

            return $query->where(function($query) use ($user_id) {
                $query->whereIn('anggota_id', $user_id)
                        ->orWhereIn('koordinator_id', $user_id);
            });
        });

        // Filter by tanggal
        if ($this->start_date != null and $this->end_date != null) {
            $kinerja->when($this->start_date, function ($query) {
                return $query->whereDate('tanggal', '>=', $this->start_date);
            });
            $kinerja->when($this->end_date, function ($query) {
                return $query->whereDate('tanggal', '<=', $this->end_date);
            });
        }

        // Order By
        $kinerja = $kinerja->orderBy('tanggal', $this->sort)
                        ->orderBy('created_at', $this->sort)
                        ->get();

        return view('user.simoja.kasi.kinerja.export.excel', [
            'kinerja' => $kinerja,
        ]);
    }
}

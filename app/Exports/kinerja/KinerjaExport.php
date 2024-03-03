<?php

namespace App\Exports\kinerja;

use App\Models\Kinerja;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KinerjaExport implements FromView, ShouldAutoSize
{
    public $anggota_id;
    public $pulau_id;
    public $seksi_id;
    public $koordinator_id;
    public $tim_id;
    public $start_date;
    public $end_date;
    public function __construct(?string $anggota_id = null, ?int $pulau_id = null, ?int $seksi_id = null, ?int $koordinator_id = null, ?int $tim_id, ?string $start_date = null, ?string $end_date = null)
    {
        $this->anggota_id = $anggota_id;
        $this->pulau_id = $pulau_id;
        $this->seksi_id = $seksi_id;
        $this->koordinator_id = $koordinator_id;
        $this->tim_id = $tim_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    public function view(): View
    {
        $kinerja = Kinerja::query();

        // Filter by anggota_id
        $kinerja->when($this->anggota_id, function ($query) {
            return $query->whereRelation('anggota', 'uuid', '=', $this->anggota_id);
        });

        // Filter by pulau_id
        $kinerja->when($this->pulau_id, function ($query) {
            return $query->where('pulau_id', $this->pulau_id);
        });

        // Filter by seksi_id
        $kinerja->when($this->seksi_id, function ($query) {
            return $query->where('seksi_id', '=', $this->seksi_id);
        });

        // Filter by koordinator_id
        $kinerja->when($this->koordinator_id, function ($query) {
            return $query->where('koordinator_id', '=', $this->koordinator_id);
        });

        // Filter by tim_id
        $kinerja->when($this->tim_id, function ($query) {
            return $query->where('tim_id', '=', $this->tim_id);
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

        return view('pages.kinerja.export.excel', [
            'kinerja' => $kinerja->orderBy('tanggal', 'ASC')->get(),
        ]);
    }
}
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
    public function __construct(
        public ?int $seksi_id = null,
        public ?int $user_id = null,
        public ?int $pulau_id = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public ?string $sort = 'asc' // default
    ) {}

    public function view(): View
    {
        $absensi = Absensi::query()
            ->when($this->seksi_id, fn($q) =>
                $q->whereRelation('user.struktur.seksi', 'id', $this->seksi_id)
            )
            ->when($this->user_id, fn($q) =>
                $q->where('user_id', $this->user_id)
            )
            ->when($this->pulau_id, fn($q) =>
                $q->whereRelation('user.area.pulau', 'id', $this->pulau_id)
            )
            ->when($this->start_date && $this->end_date, fn($q) =>
                $q->whereBetween('tanggal', [$this->start_date, $this->end_date])
            )
            ->orderBy('tanggal', $this->sort ?? 'asc')
            ->orderBy('jam_masuk', $this->sort ?? 'asc')
            ->orderBy('jam_pulang', $this->sort ?? 'asc')
            ->get();

        return view('user.simoja.kasi.absensi.export.excel', compact('absensi'));
    }
}

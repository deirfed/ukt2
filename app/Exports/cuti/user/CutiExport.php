<?php

namespace App\Exports\cuti\user;

use App\Models\Cuti;
use App\Models\FormasiTim;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CutiExport implements FromView, ShouldAutoSize
{
    public function __construct(
        public ?int $seksi_id = null,
        public ?int $user_id = null,
        public ?int $pulau_id = null,
        public ?int $jenis_cuti_id = null,
        public ?int $status = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public ?string $sort = 'asc' // default
    ) {}

    public function view(): View
    {
        $cuti = Cuti::query()
            ->when($this->seksi_id, fn($q) =>
                $q->whereRelation('user.struktur.seksi', 'id', '=', $this->seksi_id)
            )
            ->when($this->user_id, fn($q) =>
                $q->where('user_id', $this->user_id)
            )
            ->when($this->pulau_id, fn($q) =>
                $q->whereRelation('user.area.pulau', 'id', '=', $this->pulau_id)
            )
            ->when($this->jenis_cuti_id, fn($q) =>
                $q->where('jenis_cuti_id', $this->jenis_cuti_id)
            )
            ->when($this->status, fn($q) =>
                $q->where('status', $this->status)
            )
            ->when($this->start_date && $this->end_date, fn($q) =>
                $q->whereBetween('tanggal_awal', [$this->start_date, $this->end_date])
            )
            ->orderBy('tanggal_awal', $this->sort ?? 'asc')
            ->get();

        return view('user.simoja.kasi.cuti.export.excel', [
            'cuti' => $cuti,
        ]);
    }
}

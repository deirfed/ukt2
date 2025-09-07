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
    public function __construct(
        public ?int $seksi_id = null,
        public ?int $user_id = null,
        public ?int $pulau_id = null,
        public ?int $kategori_id = null,
        public ?string $start_date = null,
        public ?string $end_date = null,
        public ?string $sort = 'asc' // default
    ) {}

    public function view(): View
    {
        $kinerja = Kinerja::query()
            ->when($this->seksi_id, fn($q) =>
                $q->where('seksi_id', $this->seksi_id)
            )
            ->when($this->user_id, fn($q) =>
                $q->where('anggota_id', $this->user_id)
            )
            ->when($this->pulau_id, fn($q) =>
                $q->where('pulau_id', $this->pulau_id)
            )
            ->when($this->kategori_id, fn($q) =>
                $q->where('kategori_id', $this->kategori_id)
            )
            ->when($this->start_date && $this->end_date, fn($q) =>
                $q->whereBetween('tanggal', [$this->start_date, $this->end_date])
            )
            ->orderBy('tanggal', $this->sort ?? 'asc')
            ->get();

        return view('user.simoja.kasi.kinerja.export.excel', [
            'kinerja' => $kinerja,
        ]);
    }
}

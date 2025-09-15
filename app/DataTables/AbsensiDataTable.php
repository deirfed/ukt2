<?php

namespace App\DataTables;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AbsensiDataTable extends DataTable
{
    protected $start_date;
    protected $end_date;
    protected $seksi_id;
    protected $user_id;
    protected $pulau_id;

    public function with(array|string $key, mixed $value = null): static
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->{$k} = $v;
            }
        } else {
            $this->{$key} = $value;
        }

        return $this;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('#', function ($item) {
                $photoMasuk = asset('storage/' . $item->photo_masuk);
                $photoPulang = asset('storage/' . $item->photo_pulang);
                $actionButton = "<a href='#' data-toggle='modal' data-target='#modalDokumentasi'
                                    data-photo_masuk='{$photoMasuk}'
                                    data-photo_pulang='{$photoPulang}'>
                                    <button class='btn btn-outline-primary'>
                                        <i class='fa fa-eye'></i>
                                    </button>
                                </a>";

                return $actionButton;
            })
            ->addColumn('status_masuk', function ($item) {
                $badgeClass = $item->telat_masuk > 0 ? 'badge badge-pill badge-warning' : '';
                $telatText  = $item->telat_masuk > 0 ? $item->telat_masuk . ' menit' : '';

                return "
                    <div class='{$badgeClass}'>
                        " . ($item->status_masuk ?? '-') . "<br>
                        {$telatText}
                    </div>
                ";
            })
            ->addColumn('status_pulang', function ($item) {
                $badgeClass = $item->cepat_pulang > 0 ? 'badge badge-pill badge-warning' : '';
                $cepatText  = $item->cepat_pulang > 0 ? $item->cepat_pulang . ' menit' : '';

                return "
                    <div class='{$badgeClass}'>
                        " . ($item->status_pulang ?? '-') . "<br>
                        {$cepatText}
                    </div>
                ";
            })
            ->addColumn('status', function ($item) {
                $badgeClass = match ($item->status) {
                    'Tidak Absen Datang' => 'badge badge-pill badge-danger',
                    'Absensi Datang'     => 'badge badge-pill badge-warning',
                    'Cuti Tahunan'       => 'badge badge-pill badge-dark',
                    'Izin Sakit'         => 'badge badge-pill badge-dark',
                    default              => 'badge badge-pill badge-primary',
                };

                return "
                    <div class='{$badgeClass}'>
                        {$item->status}
                    </div>
                ";
            })
            ->addColumn('catatan', function ($item) {
                $catatanMasuk  = $item->catatan_masuk ?? '-';
                $catatanPulang = $item->catatan_pulang ?? '-';

                return "
                    <span class='font-weight-bold'>Datang:</span> {$catatanMasuk}<br>
                    <span class='font-weight-bold'>Pulang:</span> {$catatanPulang}
                ";
            })
            ->rawColumns(['status_masuk', 'status_pulang', 'status', 'catatan', '#']);
    }

    public function query(Absensi $model): QueryBuilder
    {
        $query = $model->with([
            'user.jabatan',
            'user.area.pulau',
            'user.struktur.seksi',
        ])->newQuery();

        // Filter
        if($this->seksi_id != null)
        {
            $query->whereRelation('user.struktur.seksi', 'id', '=', $this->seksi_id);
        }

        if($this->user_id != null)
        {
            $query->where('user_id', $this->user_id);
        }

        if($this->pulau_id != null)
        {
            $query->whereRelation('user.area.pulau', 'id', '=', $this->pulau_id);
        }

        if ($this->start_date != null && $this->end_date != null) {
            $clean_start_date = explode('?', $this->start_date)[0];
            $clean_end_date = explode('?', $this->end_date)[0];

            $start = Carbon::parse($clean_start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($clean_end_date)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('tanggal', [$start, $end]);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('absensi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(50)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([0, 'desc'])
                    ->selectStyleSingle()
                    ->buttons([
                        [
                            'extend' => 'excel',
                            'text' => 'Export to Excel',
                            'attr' => [
                                'id' => 'datatable-excel',
                                'style' => 'display: none;',
                            ],
                        ],
                    ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('tanggal')->title('Tanggal')->sortable(true),
            Column::make('user.name')->title('Nama')->addClass('font-weight-bold')->sortable(true),
            Column::make('user.jabatan.name')->title('Jabatan')->sortable(false),
            Column::make('user.area.pulau.name')->title('Pulau')->sortable(false),
            Column::make('user.struktur.seksi.name')->title('Seksi')->addClass('text-wrap')->sortable(false),
            Column::make('jam_masuk')->title('Jam Datang')->sortable(false),
            Column::computed('status_masuk')->title('Status Datang')->sortable(false),
            Column::make('jam_pulang')->title('Jam Pulang')->sortable(false),
            Column::computed('status_pulang')->title('Status Pulang')->sortable(false),
            Column::make('status')->title('Status')->sortable(false),
            Column::computed('catatan')->title('Catatan')->sortable(false),
            Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Absensi_' . date('YmdHis');
    }
}

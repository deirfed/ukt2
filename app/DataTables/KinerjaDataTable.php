<?php

namespace App\DataTables;

use App\Models\Kinerja;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KinerjaDataTable extends DataTable
{
    protected $seksi_id;
    protected $start_date;
    protected $end_date;
    protected $user_id;
    protected $pulau_id;
    protected $kategori_id;

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
                $photo = $item->photo;
                $actionButton = "<a href='#' data-toggle='modal' data-target='#modalDokumentasi'
                                    data-photo='{$photo}'>
                                    <button class='btn btn-outline-primary'>
                                        <i class='fa fa-eye'></i>
                                    </button>
                                </a>";

                return $actionButton;
            })
            ->addColumn('giat', function ($item) {
                return $item->kategori->name ?? $item->kegiatan;
            })
            ->rawColumns(['giat', '#']);
    }

    public function query(Kinerja $model): QueryBuilder
    {
        $query = $model->with([
            'anggota',
            'pulau',
            'koordinator',
            'seksi',
        ])->newQuery();

        // Filter
        if($this->seksi_id != null)
        {
            $query->where('seksi_id', $this->seksi_id);
        }

        if($this->user_id != null)
        {
            $query->where('anggota_id', $this->user_id);
        }

        if($this->pulau_id != null)
        {
            $query->where('pulau_id', $this->pulau_id);
        }

        if($this->kategori_id != null)
        {
            $query->where('kategori_id', $this->kategori_id);
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
                    ->setTableId('kinerja-table')
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
            Column::make('anggota.name')->title('Nama')->addClass('font-weight-bold text-nowrap')->sortable(true),
            Column::make('pulau.name')->title('Pulau')->sortable(false)->addClass('text-nowrap'),
            Column::make('koordinator.name')->title('Koordinator')->sortable(false)->addClass('text-nowrap'),
            Column::make('seksi.name')->title('Seksi')->sortable(false),
            Column::computed('giat')->title('Giat')->sortable(false),
            Column::make('deskripsi')->title('Deskripsi')->sortable(false),
            Column::make('lokasi')->title('Lokasi')->sortable(false),
            Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Kinerja_' . date('YmdHis');
    }
}

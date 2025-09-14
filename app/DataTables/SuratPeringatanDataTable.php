<?php

namespace App\DataTables;

use App\Models\SuratPeringatan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SuratPeringatanDataTable extends DataTable
{
    protected $tahun;

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
            ->addColumn('aksi', function ($item) {
                $routeDelete = route('admin.surat-peringatan.destroy', $item->uuid);
                $actionButton = "<a href='#' data-toggle='modal' data-target='#delete-confirmation-modal'
                                    data-url='{$routeDelete}'>
                                    <button class='btn btn-outline-danger'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </a>";

                return $actionButton;
            })
            ->addColumn('dokumen', function ($item) {
                $routeDokumen = asset('storage/' . $item->dokumen);
                $actionButton = "<a href='{$routeDokumen}' target='_blank'>
                    <button class='btn btn-outline-primary'>
                        <i class='fa fa-file'></i>
                    </button>
                </a>";

                return $actionButton;
            })
            ->rawColumns(['dokumen', 'aksi']);
    }

    public function query(SuratPeringatan $model): QueryBuilder
    {
        $query = $model->select('surat_peringatan.*')->with([
            'user.jabatan',
            'user.area.pulau',
            'user.struktur.seksi',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('suratperingatan-table')
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
            Column::make('jenis')->title('Jenis')->sortable(false),
            Column::make('alasan')->title('Alasan')->addClass('text-wrap')->sortable(false),
            Column::make('sanksi')->title('Sanksi')->addClass('text-wrap')->sortable(false),
            Column::computed('dokumen')
                ->exportable(false)
                ->printable(false)
                ->title('Dokumen')
                ->addClass('text-center'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->title('Aksi')
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'SuratPeringatan_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\FormasiTim;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FormasiTimDataTable extends DataTable
{
    protected $periode;

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
                // Tombol Edit
                $routeEdit = route('admin-formasi_tim.edit', $item->uuid);
                $editButton = "
                    <a href='{$routeEdit}'>
                        <button class='btn btn-outline-primary'>
                            <i class='fa fa-edit'></i>
                        </button>
                    </a>
                ";

                // Tombol Delete
                $deleteButton = "
                    <a href='javascript:;'
                        data-toggle='modal'
                        data-target='#delete-confirmation-modal'
                        onclick=\"toggleModal('{$item->id}')\">
                        <button class='btn btn-outline-danger'>
                            <i class='fa fa-trash'></i>
                        </button>
                    </a>
                ";

                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['aksi']);
    }

    public function query(FormasiTim $model): QueryBuilder
    {
        $query = $model->select('formasi_tim.*')->with([
            'struktur.tim',
            'struktur.seksi',
            'koordinator',
            'anggota',
            'area.pulau',
        ])->newQuery();

        $periode = $this->periode ?? Carbon::now()->format('Y');

        $query->where('periode', $periode);

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('formasitim-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(50)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([2, 'asc'])
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
            Column::make('periode')->title('Tahun')->sortable(true),
            Column::make('struktur.tim.name')->title('Nama Tim')->sortable(true),
            Column::make('struktur.seksi.name')->title('Seksi')->sortable(true),
            Column::make('koordinator.name')->title('Koordinator')->sortable(true),
            Column::make('anggota.name')->title('PJLP')->sortable(true),
            Column::make('area.pulau.name')->title('Pulau')->sortable(true),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'FormasiTim_' . date('YmdHis');
    }
}

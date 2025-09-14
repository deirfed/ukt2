<?php

namespace App\DataTables;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KategoriDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('aksi', function ($item) {
                // Tombol Edit
                $routeEdit = route('admin-kategori.edit', $item->uuid);
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

    public function query(Kategori $model): QueryBuilder
    {
        $query = $model->select('kategori.*')->with([
            'seksi',
        ])->newQuery();

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kategori-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(50)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([1, 'asc'])
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
            Column::make('name')->title('Nama Kegiatan')->sortable(true),
            Column::make('seksi.name')->title('Seksi')->sortable(true),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Kategori_' . date('YmdHis');
    }
}

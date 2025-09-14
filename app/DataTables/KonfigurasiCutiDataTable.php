<?php

namespace App\DataTables;

use App\Models\KonfigurasiCuti;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KonfigurasiCutiDataTable extends DataTable
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
                $routeEdit = route('admin-konfigurasi_cuti.edit', $item->uuid);
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
            ->addColumn('jumlah', function ($item) {
                return $item->jumlah . ' hari';
            })
            ->rawColumns(['jumlah', 'aksi']);
    }

    public function query(KonfigurasiCuti $model): QueryBuilder
    {
        $query = $model->select('konfigurasi_cuti.*')->with([
            'user.jabatan',
            'jenis_cuti',
        ])->newQuery();

        $periode = $this->periode ?? Carbon::now()->format('Y');

        $query->where('periode', $periode);

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('konfigurasicuti-table')
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
            Column::make('periode')->title('Tahun')->sortable(true),
            Column::make('user.name')->title('Nama Karyawan')->sortable(true),
            Column::make('user.jabatan.name')->title('Jabatan')->sortable(false),
            Column::make('jenis_cuti.name')->title('Jenis Cuti')->sortable(false),
            Column::make('jumlah')->title('Jumlah Cuti')->sortable(false),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'KonfigurasiCuti_' . date('YmdHis');
    }
}

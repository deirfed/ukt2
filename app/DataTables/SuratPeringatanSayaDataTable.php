<?php

namespace App\DataTables;

use App\Models\SuratPeringatan;
use App\Models\SuratPeringatanSaya;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SuratPeringatanSayaDataTable extends DataTable
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
        return (new EloquentDataTable($query));
    }

    public function query(SuratPeringatan $model): QueryBuilder
    {
        $query = $model->with([
            'user.jabatan',
        ])->newQuery();

        // Filter
        $user_id = auth()->user()->id;
        $query->where('user_id', $user_id);

        if($this->tahun != null)
        {
            $query->whereYear('tanggal', $this->tahun);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('suratperingatansaya-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(10)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([0, 'asc'])
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
            Column::make('jenis')->title('Jenis SP')->sortable(false),
            Column::make('alasan')->title('Keterangan')->sortable(false)->addClass('text-wrap'),
        ];
    }

    protected function filename(): string
    {
        return 'SuratPeringatanSaya_' . date('YmdHis');
    }
}

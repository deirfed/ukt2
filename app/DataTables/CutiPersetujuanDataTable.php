<?php

namespace App\DataTables;

use App\Models\Cuti;
use App\Models\CutiPersetujuan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CutiPersetujuanDataTable extends DataTable
{
    protected $approved_by_id;

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
                // Tombol Approve
                $approveButton = "
                    <a href='javascript:;' class='btn btn-outline-primary'
                        title='Terima'
                        data-toggle='modal'
                        data-target='#approveModal'
                        data-id='{$item->id}'>
                        <i class='fa fa-check'></i>
                    </a>";

                // Tombol Reject
                $rejectButton = "
                    <a href='javascript:;' class='btn btn-outline-secondary'
                        title='Tolak'
                        data-toggle='modal'
                        data-target='#rejectModal'
                        data-id='{$item->id}'>
                        <i class='fa fa-times'></i>
                    </a>";

                // URL Lampiran
                $lampiranURL = $item->lampiran
                    ? asset('storage/' . $item->lampiran)
                    : 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg';

                // Status text (Blade -> PHP string)
                if ($item->status == 'Diproses') {
                    $statusText = "<h5>*Pengajuan Cuti masih Dalam Proses persetujuan</h5>";
                } elseif ($item->status == 'Ditolak') {
                    $statusText = "<h5>*Pengajuan Cuti <span style='color: red'>Ditolak</span></h5>";
                } else {
                    $statusText = "<h5>*Pengajuan Cuti Sudah <span style='color: green'>Disetujui</span> pada Tanggal {$item->updated_at}</h5>";
                }

                // Tombol Detail (Lampiran)
                $lampiranButton = "
                    <a href='javascript:;' class='btn btn-outline-primary'
                        title='Lihat lampiran'
                        data-toggle='modal'
                        data-target='#modalDetailPengajuan'
                        data-lampiran='{$lampiranURL}'
                        data-nama='{$item->user->name}'
                        data-jenis_cuti='{$item->jenis_cuti->name} ({$item->jumlah} hari)'
                        data-koordinator='{$item->known_by->name}'
                        data-periode='{$item->tanggal_awal} s/d {$item->tanggal_akhir}'
                        data-tim='{$item->user->struktur->tim->name} (Pulau {$item->user->area->pulau->name})'
                        data-catatan='{$item->catatan}'
                        data-status=\"{$statusText}\">
                        <i class='fa fa-eye'></i>
                    </a>";

                return $approveButton . ' ' . $rejectButton . ' ' . $lampiranButton;
            })
            ->addColumn('jumlah_hari', function ($item) {
                return $item->jumlah . ' hari';
            })
            ->rawColumns(['jumlah_hari', '#']);
    }

    public function query(Cuti $model): QueryBuilder
    {
        $query = $model->select('cuti.*')->with([
            'user.jabatan',
            'user.area.pulau',
            'jenis_cuti',
            'user.konfigurasi_cuti',
            'known_by',
            'approved_by',
        ])->newQuery();

        $query->where('status', 'Diproses');

        if($this->approved_by_id != null)
        {
            $query->where('approved_by_id', $this->approved_by_id);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('cutipersetujuan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(50)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([3, 'desc'])
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
            Column::make('user.name')->title('Nama')->addClass('font-weight-bold text-nowrap')->sortable(true),
            Column::make('user.jabatan.name')->title('Jabatan')->sortable(false),
            Column::make('user.area.pulau.name')->title('Pulau')->sortable(false),
            Column::make('tanggal_awal')->title('Tanggal Awal')->sortable(true),
            Column::make('tanggal_akhir')->title('Tanggal Akhir')->sortable(true),
            Column::computed('jumlah_hari')->title('Jumlah Hari')->sortable(false),
            Column::make('jenis_cuti.name')->title('Jenis Izin')->sortable(false),
            Column::make('known_by.name')->title('Koordinator')->sortable(false),
            Column::make('approved_by.name')->title('Kepala Seksi')->sortable(false),
            Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'CutiPersetujuan_' . date('YmdHis');
    }
}

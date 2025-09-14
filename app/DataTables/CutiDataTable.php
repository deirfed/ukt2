<?php

namespace App\DataTables;

use App\Models\Cuti;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CutiDataTable extends DataTable
{
    protected $start_date;
    protected $end_date;
    protected $seksi_id;
    protected $user_id;
    protected $pulau_id;
    protected $jenis_cuti_id;
    protected $status;

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
                $printURL = route('cuti.pdf', $item->uuid);
                $printButton = "<a href='javascript:;' class='btn btn-outline-primary'
                                    title='Print' title='Download PDF' data-toggle='modal'
                                    data-target='#modalDownloadPDF'
                                    data-href='{$printURL}'>
                                    <i class='fa fa-print'></i>
                                </a>";

                $lampiranURL = $item->lampiran != null ? asset('storage/' . $item->lampiran) : 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg';
                $lampiranButton = "<a href='javascript:;' class='btn btn-outline-primary'
                                    title='Lihat lampiran' data-toggle='modal'
                                    data-target='#modalLampiran'
                                    data-lampiran='{$lampiranURL}'>
                                    <i class='fa fa-eye'></i>
                                </a>";

                if ($item->status == 'Diterima') {
                    return $printButton . ' ' . $lampiranButton;
                }

                return $lampiranButton;
            })
            ->addColumn('jumlah_hari', function ($item) {
                return $item->jumlah . ' hari';
            })
            ->addColumn('disetujui', function ($item) {
                return $item->status == 'Diterima'
                    ? ($item->approved_by->name ?? '-')
                    : '-';
            })
            ->addColumn('status', function ($item) {
                $class = match ($item->status) {
                    'Diproses' => 'btn-warning',
                    'Ditolak'  => 'btn-secondary',
                    default    => 'btn-primary',
                };

                return '<span class="btn ' . $class . '">' . e($item->status) . '</span>';
            })
            ->rawColumns(['jumlah_hari', 'disetujui', 'status', '#']);
    }

    public function query(Cuti $model): QueryBuilder
    {
        $query = $model->select('cuti.*')->with([
            'user.struktur.seksi',
            'user.jabatan',
            'user.area.pulau',
            'jenis_cuti',
            'user.konfigurasi_cuti',
            'known_by',
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

        if($this->jenis_cuti_id != null)
        {
            $query->where('jenis_cuti_id', $this->jenis_cuti_id);
        }

        if($this->status != null)
        {
            $query->where('status', $this->status);
        }

        if ($this->start_date != null && $this->end_date != null) {
            $clean_start_date = explode('?', $this->start_date)[0];
            $clean_end_date = explode('?', $this->end_date)[0];

            $start = Carbon::parse($clean_start_date)->startOfDay()->format('Y-m-d H:i:s');
            $end = Carbon::parse($clean_end_date)->endOfDay()->format('Y-m-d H:i:s');

            $query->whereBetween('tanggal_awal', [$start, $end]);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('cuti-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(50)
                    ->lengthMenu([10, 50, 100, 250, 500, 1000])
                    ->orderBy([4, 'desc'])
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
            Column::make('user.struktur.seksi.name')->title('Seksi')->sortable(false),
            Column::make('user.area.pulau.name')->title('Pulau')->sortable(false),
            Column::make('tanggal_awal')->title('Tanggal Awal')->sortable(true),
            Column::make('tanggal_akhir')->title('Tanggal Akhir')->sortable(true),
            Column::make('jenis_cuti.name')->title('Jenis Izin')->sortable(false),
            Column::computed('jumlah_hari')->title('Jumlah Hari')->sortable(false),
            Column::make('user.konfigurasi_cuti.jumlah')->title('Sisa Cuti')->sortable(false),
            Column::make('known_by.name')->title('Koordinator')->sortable(false),
            Column::computed('disetujui')->title('Disetujui')->sortable(false),
            Column::computed('status')->title('Status')->addClass('text-center')->sortable(false),
            // Column::make('catatan')->title('Catatan')->sortable(false)->addClass('text-wrap'),
            Column::computed('#')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Cuti_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\Cuti;
use App\Models\CutiSaya;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CutiSayaDataTable extends DataTable
{
    protected $user_id;
    protected $start_date;
    protected $end_date;
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
            ->addColumn('#', function ($item) {
                $printURL = route('cuti.pdf', $item->uuid);
                $printButton = "<a href='javascript:;' class='btn btn-outline-primary'
                                    title='Print' title='Download PDF' data-toggle='modal'
                                    data-target='#modalDownloadPDF'
                                    data-href='{$printURL}'>
                                    <i class='fa fa-print'></i>
                                </a>";

                $lampiranURL = $item->lampiran != null ? asset('storage/' . $item->lampiran) : 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg';

                if ($item->status == 'Diproses') {
                    $statusCuti = "<h5>*Pengajuan Cuti masih Dalam Proses persetujuan</h5>";
                } elseif ($item->status == 'Ditolak') {
                    $statusCuti = "<h5>*Pengajuan Cuti <span style='color: red'>Ditolak</span></h5>";
                } else {
                    $statusCuti = "<h5>*Pengajuan Cuti Sudah <span style='color: green'>Disetujui</span> pada Tanggal {$item->updated_at}</h5>";
                }

                // Encode biar aman ditaruh di atribut HTML
                $statusAttr = htmlspecialchars($statusCuti, ENT_QUOTES, 'UTF-8');

                $lampiranButton = "
                    <a href='javascript:;' class='btn btn-outline-primary'
                        title='Lihat lampiran' data-toggle='modal'
                        data-target='#modalDetailPengajuan'
                        data-lampiran='{$lampiranURL}'
                        data-nama='{$item->user->name}'
                        data-jenis_cuti='{$item->jenis_cuti->name} ({$item->jumlah} hari)'
                        data-koordinator='{$item->known_by->name}'
                        data-periode='{$item->tanggal_awal} s/d {$item->tanggal_akhir}'
                        data-tim='{$item->user->struktur->tim->name} (Pulau {$item->user->area->pulau->name})'
                        data-catatan='{$item->catatan}'
                        data-status=\"{$statusAttr}\">
                        <i class='fa fa-eye'></i>
                    </a>
                ";

                $deleteButton = "<a href='javascript:;' class='btn btn-outline-secondary'
                                    title='Hapus' data-toggle='modal' data-target='#deleteModal'
                                    data-id='{{ $item->id }}'>
                                    <i class='fa fa-trash'></i>
                                </a>";

                if ($item->status == 'Diterima') {
                    return $printButton . ' ' . $lampiranButton;
                }

                return $lampiranButton . ' ' . $deleteButton;
            })
            ->addColumn('jumlah_hari', function ($item) {
                return $item->jumlah . ' hari';
            })
            ->addColumn('sisa_cuti', function ($item) {
                $jatah = 12; //default per tahun

                // Hitung total cuti yang sudah diambil di this->periode itu, SEBELUM cuti ini
                $totalDiambil = Cuti::where('user_id', $item->user_id)
                    ->whereYear('tanggal_awal', $this->periode)
                    ->where('tanggal_awal', '<', $item->tanggal_awal)
                    ->sum('jumlah');

                return $jatah - $totalDiambil - $item->jumlah . ' hari';
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
            'user.jabatan',
            'user.area.pulau',
            'jenis_cuti',
            'user.konfigurasi_cuti',
            'known_by',
        ])->newQuery();

        // Filter
        if ($this->user_id != null) {
            $query->where('user_id', $this->user_id);
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
                    ->setTableId('cutisaya-table')
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
            Column::make('jenis_cuti.name')->title('Jenis Izin')->sortable(false),
            Column::computed('jumlah_hari')->title('Jumlah Hari')->sortable(false),
            // Column::make('user.konfigurasi_cuti.jumlah')->title('Sisa Cuti')->sortable(false),
            Column::computed('sisa_cuti')->title('Sisa Cuti')->sortable(false),
            Column::make('known_by.name')->title('Koordinator')->sortable(false),
            Column::computed('disetujui')->title('Disetujui')->sortable(false),
            Column::computed('status')->title('Status')->sortable(false),
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
        return 'CutiSaya_' . date('YmdHis');
    }
}

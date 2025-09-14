<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    protected $employee_type_id;

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
                $showButton = "
                    <a href='" . route('admin-user.show', $item->uuid) . "' title='Show User'>
                        <button class='btn btn-primary'>
                            <i class='fa fa-eye'></i>
                        </button>
                    </a>
                ";

                $routeBanOrUnban = route('admin-user.ban-or-unban', $item->uuid);
                if ($item->isBanned()) {
                    // Kalau user BANNED → tampilkan tombol Unban
                    $banOrUnbanButton = "
                        <button class='btn btn-outline-success' title='Unban User'
                            data-toggle='modal'
                            data-target='#unbanUser'
                            data-url='{$routeBanOrUnban}'
                            data-username='{$item->name}'
                            data-userid='{$item->id}'>
                            <i class='fa fa-check'></i>
                        </button>
                    ";
                } else {
                    // Kalau user masih aktif → tampilkan tombol Ban
                    $banOrUnbanButton = "
                        <button class='btn btn-outline-danger' title='Ban User'
                            data-toggle='modal'
                            data-target='#banUser'
                            data-url='{$routeBanOrUnban}'
                            data-username='{$item->name}'
                            data-userid='{$item->id}'>
                            <i class='fa fa-ban'></i>
                        </button>
                    ";
                }

                $routeResetPassword = route('admin-user.reset-password', $item->uuid);
                $resetPasswordButton = "
                    <button class='btn btn-warning' title='Reset Password User'
                        data-toggle='modal'
                        data-target='#resetPasswordModal'
                        data-url='{$routeResetPassword}'
                        data-username='{$item->name}'
                        data-userid='{$item->id}'>
                        <i class='fa fa-asterisk text-white'></i>
                    </button>
                ";

                return $showButton . $banOrUnbanButton . $resetPasswordButton;
            })
            ->addColumn('status', function ($item) {
                if ($item->isBanned()) {
                    return "<span class='badge badge-danger'>Banned</span>";
                }
                return "<span class='badge badge-primary'>Active</span>";
            })
            ->addColumn('surat_teguran', function ($item) {
                $warnings = $item->surat_peringatans()
                    ->whereYear('tanggal', now()->year)
                    ->count();

                $output = '';

                $routeSuratPeringatan = route('admin.surat-peringatan.store', $item->uuid);
                for ($i = 1; $i <= 3; $i++) {
                    $color = $warnings >= $i ? '#dc3545' : '#6c757d';
                    $output .= "
                        <span class='d-inline-block rounded-circle me-1'
                            style='width: 18px; height: 18px; background-color: {$color};'
                            role='button'
                            data-toggle='modal'
                            data-target='#uploadSuratModal'
                            data-url='{$routeSuratPeringatan}'
                            data-username='{$item->name}'
                            data-userid='{$item->id}'
                            data-warnings='{$warnings}'>
                        </span>
                    ";
                }

                return $output;
            })
            ->rawColumns(['status', 'surat_teguran', 'aksi']);
    }

    public function query(User $model): QueryBuilder
    {
        $query = $model->with([
            'jabatan',
            'area.pulau',
        ])->newQuery();

        // Filter
        $query->whereNot('jabatan_id', 6);

        if($this->employee_type_id != null)
        {
            $query->where('employee_type_id', $this->employee_type_id);
        }

        return $query;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(50)
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
            Column::make('name')->title('Nama')->addClass('font-weight-bold')->sortable(true),
            Column::make('email')->title('Email')->sortable(false),
            Column::make('jabatan.name')->title('Jabatan')->sortable(false),
            Column::make('area.pulau.name')->title('Pulau')->sortable(false),
            Column::computed('status')->title('Status User')
                ->addClass('text-center')
                ->sortable(false),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->title('Aksi'),
            Column::computed('surat_teguran')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->title('Surat Teguran'),
        ];
    }

    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}

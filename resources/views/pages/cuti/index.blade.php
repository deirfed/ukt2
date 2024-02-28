@extends('layout.base')

@section('title-head')
    <title>
        Cuti | Permohonan Cuti / Izin
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Cuti</li>
            <li class="breadcrumb-item active">Pengaturan Cuti</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-user"></i>
                </div>
                <div class="sale-num">
                    <h4>12</h4>
                    <p>Jatah Cuti Tahunan</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-user-minus"></i>
                </div>
                <div class="sale-num">
                    <h4>XX</h4>
                    <p>Dev Proccess</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-shopping-bag1"></i>
                </div>
                <div class="sale-num">
                    <h4>XX</h4>
                    <p>Dev Proccess</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-activity"></i>
                </div>
                <div class="sale-num">
                    <h4>XX</h4>
                    <p>Dev Proccess</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 col-12">
            <div class="card h-250">
                <div class="card-header">
                    <div class="card-title">Data Pengajuan Cuti / Izin</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <button class="btn btn-primary">Export to Excel</i></button>
                            <button class="btn btn-primary">Export to PDF</button>
                            <button class="btn btn-primary"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center text-wrap">Nama</th>
                                            <th class="text-center text-wrap">Tanggal Pengajuan</th>
                                            <th class="text-center text-wrap">Jenis Pengajuan</th>
                                            <th class="text-center text-wrap">Jumlah Hari</th>
                                            <th class="text-center text-wrap">Diketahui</th>
                                            <th class="text-center text-wrap">Disetujui</th>
                                            <th class="text-center text-wrap">Status</th>
                                            <th class="text-center text-wrap">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuti as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center text-wrap">
                                                    {{ $item->tanggal_awal }} - {{ $item->tanggal_akhir }}
                                                </td>
                                                <td class="text-center">{{ $item->jenis_cuti->name }}</td>
                                                <td class="text-center">{{ $item->jumlah }} hari</td>
                                                <td class="text-center">
                                                    {{ $item->known_by->name }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->status == 'Approved')
                                                        {{ $item->approved_by->name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="btn @if ($item->status == 'Diproses') btn-warning @elseif ($item->status == 'Ditolak') btn-secondary @else btn-primary @endif">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-outline-primary" title="Print">
                                                        <i class="fa fa-print"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline-primary" title="Lihat"
                                                        data-toggle="modal" data-target="#modalLampiran"
                                                        data-lampiran="{{ asset('storage/' . $item->lampiran) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-outline-secondary" title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 col-12">
            <div class="card h-250">
                <div class="card-header">
                    <div class="card-title">Daftar Proses Pengajuan</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar-2">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            @if ($approval_cuti->count() > 0)
                                <a href="javascript:;" class="btn btn-primary">Setujui Semua</a>
                            @endif
                        </div>
                    </div>
                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jumlah Hari</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approval_cuti as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center">
                                                    {{ $item->jumlah }} hari
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:;" class="btn btn-outline-primary"
                                                        title="Approve">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline-secondary"
                                                        title="Tolak">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline-primary"
                                                        title="Lihat">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($approval_cuti->count() == 0)
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    Tidak ada data.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="detailPersonel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Lampiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-modal-user gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="formasi-modal p-2 text-center">
                                <img id="photoLampiran" src="#" alt="LAMPIRAN" class="img-thumbnail">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#modalLampiran').on('show.bs.modal', function(e) {
                var lampiran = $(e.relatedTarget).data('lampiran');
                document.getElementById("photoLampiran").src = lampiran;
            });
        });
    </script>
@endsection

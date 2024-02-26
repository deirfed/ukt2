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
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Tanggal Pengajuan</th>
                                            <th class="text-center">Jenis Pengajuan</th>
                                            <th class="text-center">Jumlah Hari</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Monarki</td>
                                            <td class="text-center">13 Juni 2023</td>
                                            <td class="text-center">Cuti Tahunan</td>
                                            <td class="text-center">2 Hari</td>
                                            <td class="text-center">
                                                <span class="btn btn-primary">Disetujui</span>
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-print"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="#" href=""><button class="btn btn-outline-primary"
                                                        disabled><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Kamiludin</td>
                                            <td class="text-center">13 April 2023</td>
                                            <td class="text-center">Izin Sakit</td>
                                            <td class="text-center">2 Hari</td>
                                            <td class="text-center">
                                                <span class="btn btn-secondary">Ditolak</span>
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-print"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="#" href=""><button class="btn btn-outline-primary"
                                                        disabled><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Monarki</td>
                                            <td class="text-center">13 Mei 2023</td>
                                            <td class="text-center">Izin Sakit</td>
                                            <td class="text-center">2 Hari</td>
                                            <td class="text-center">
                                                <span class="btn btn-warning">Diproses</span>
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-print"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="#" href=""><button class="btn btn-outline-primary"
                                                        disabled><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ridwan Hardi</td>
                                            <td class="text-center">13 Februari 2023</td>
                                            <td class="text-center">Cuti Tahunan</td>
                                            <td class="text-center">2 Hari</td>
                                            <td class="text-center">
                                                <span class="btn btn-warning">Diproses</span>
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-print"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="#" href=""><button class="btn btn-outline-primary"
                                                        disabled><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Jokowi</td>
                                            <td class="text-center">13 Februari 2023</td>
                                            <td class="text-center">Cuti Tahunan</td>
                                            <td class="text-center">2 Hari</td>
                                            <td class="text-center">
                                                <span class="btn btn-warning">Diproses</span>
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-print"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="#" href=""><button class="btn btn-outline-primary"
                                                        disabled><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Monarki</td>
                                            <td class="text-center">10 Juli 2023</td>
                                            <td class="text-center">Cuti Tahunan</td>
                                            <td class="text-center">2 Hari</td>
                                            <td class="text-center">
                                                <span class="btn btn-warning">Diproses</span>
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-print"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                                <a href="#" href=""><button class="btn btn-outline-primary"
                                                        disabled><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
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
                            <button class="btn btn-primary">Setujui Semua</i></button>
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
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Monarki</td>
                                            <td class="text-center"> 2 Hari
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-check"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-times"></i></button></a>
                                                <a href="#" href="javascript:;" data-toggle="modal"
                                                    data-target=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Zaki Putra</td>
                                            <td class="text-center"> 2 Hari
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-check"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-times"></i></button></a>
                                                <a href="#" href="javascript:;" data-toggle="modal"
                                                    data-target=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Putra Roh Kudus</td>
                                            <td class="text-center"> 2 Hari
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-check"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-times"></i></button></a>
                                                <a href="#" href="javascript:;" data-toggle="modal"
                                                    data-target=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Monarki</td>
                                            <td class="text-center"> 2 Hari
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-check"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-times"></i></button></a>
                                                <a href="#" href="javascript:;" data-toggle="modal"
                                                    data-target=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Ahmad Jejen Jajuli</td>
                                            <td class="text-center"> 2 Hari
                                            </td>
                                            <td class="text-center">
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-check"></i></button></a>
                                                <a href=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-times"></i></button></a>
                                                <a href="#" href="javascript:;" data-toggle="modal"
                                                    data-target=""><button class="btn btn-outline-primary"><i
                                                            class="fa fa-eye"></i></button></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

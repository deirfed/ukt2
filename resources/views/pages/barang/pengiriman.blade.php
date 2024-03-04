@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Barang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item active">Data Pengiriman Barang</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Pengiriman Barang</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <br>
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama & Jumlah</th>
                                    <th class="text-center"> Pengirim</th>
                                    <th class="text-center"> Tujuan</th>
                                    <th class="text-center">Status Pengiriman</th>
                                    <th class="text-center">Dikirim</th>
                                    <th class="text-center">Diterima</th>
                                    <th class="text-center">Catatan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Semen (30Zak)</td>
                                    <td class="text-center">Gudang Utama</td>
                                    <td class="text-center">Gudang Pencahayaan Pulau Tidung</td>
                                    <td class="text-center"><button class="btn btn-warning">Proses Pengiriman</button></td>
                                    <td class="text-center">13/02/2023
                                        <br> Pukul 19:40
                                    </td>
                                    <td class="text-center">-
                                        <br> -
                                    </td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-eye"></i></button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Semen (30Zak)</td>
                                    <td class="text-center">Gudang Utama</td>
                                    <td class="text-center">Gudang Pertamanan Pulau Tidung</td>
                                    <td class="text-center"><button class="btn btn-primary">Diterima</button></td>
                                    <td class="text-center">13/02/2023
                                        <br> Pukul 19:40
                                    </td>
                                    <td class="text-center">14/02/2023
                                        <br> Pukul 08:10
                                    </td>
                                    <td class="text-center">Barang Sesuai</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
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
@endsection

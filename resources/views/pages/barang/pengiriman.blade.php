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
                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                            data-target="#modalLampiran"><i class="fa fa-eye"></i></a>
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
                                        <a href="#" class="btn btn-outline-primary" data-toggle="modal"
                                            data-target="#modalLampiran"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- BEGIN: Lampiran Modal --}}
    <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="modalLampiran"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lampiran Pengiriman Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="">
                                <table style="font-size: 15px">
                                    <tbody class="mb-5">
                                        <tr>
                                            <td>No. Kontrak</td>
                                            <td> : </td>
                                            <td class="font-bolder">
                                                S.5875/DKI
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td> : </td>
                                            <td class="font-bolder">
                                               Semen Tiga Roda
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td> : </td>
                                            <td class="font-bolder">
                                                30 Zak
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Catatan</td>
                                            <td> : </td>
                                            <td class="font-bolder">
                                                -
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4 class="text-primary">Dokumentasi Pengiriman</h4>
                                </div>
                                <div class="formasi-modal p-2 text-center">
                                    <img id="photoLampiran" src="#" alt="LAMPIRAN" class="img-thumbnail">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <input type="file">
                                </div>
                                <p class="text-center">Lampiran belum tersedia, silakan input lampiran</p>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h4>Dokumentasi Penerimaan</h4>
                                </div>
                                <div class="formasi-modal p-2 text-center">
                                    <img id="photoLampiran" src="#" alt="LAMPIRAN" class="img-thumbnail">
                                </div>
                                <p class="text-center">Lampiran belum tersedia/belum diinput dari koordinator Pulau</p>
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

    {{-- END: Lampiran Modal --}}
@endsection

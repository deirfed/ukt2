@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Gudang Utama
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item">Data Pengadaan</li>
            <li class="breadcrumb-item active">No. Kontrak S4982.DKI</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-12">
                            <div class="btn-group">
                                <div class="">
                                    <table style="font-size: 15px">
                                        <tbody class="mb-5">
                                            <tr>
                                                <td>No. Kontrak</td>
                                                <td> : </td>
                                                <td class="font-bolder">
                                                    S4892.DKI
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Kontrak</td>
                                                <td> : </td>
                                                <td class="font-bolder">
                                                    Pengadaan Consumable Kepulauan Seribu Tahun 2023
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tahun Anggaran</td>
                                                <td> : </td>
                                                <td class="font-bolder">
                                                    2023
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Lokasi</td>
                                                <td> : </td>
                                                <td class="font-bolder">
                                                    Gudang Utama
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="{{ route('pengadaan.index') }}"><button class="btn btn-outline-primary">
                                    <i class="fa fa-arrow-left"></i>Kembali</button></a>
                            <a href="{{ route('gudang.distribusi') }}"><button class="btn btn-primary">
                                    Distribusi Barang</button></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Merk Barang</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Stock Saat Ini</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Spesifikasi</th>
                                    <th class="text-center">Dokumentasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Kabel NYM</td>
                                    <td class="text-center">Jembo</td>
                                    <td class="text-center">1203</td>
                                    <td class="text-center">900</td>
                                    <td class="text-center">Roll</td>
                                    <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-edit"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i class="fa fa-eye"
                                                    data-toggle="modal" data-target="#modalLampiran"></i></button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">Paralon</td>
                                    <td class="text-center">Pralon 4"</td>
                                    <td class="text-center">1203</td>
                                    <td class="text-center">900</td>
                                    <td class="text-center">Roll</td>
                                    <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-edit"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i class="fa fa-eye"
                                                    data-toggle="modal" data-target="#modalLampiran"></i></button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">Kabel NYA</td>
                                    <td class="text-center">Jembo</td>
                                    <td class="text-center">1203</td>
                                    <td class="text-center">900</td>
                                    <td class="text-center">Roll</td>
                                    <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-edit"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i class="fa fa-eye"
                                                    data-toggle="modal" data-target="#modalLampiran"></i></button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td class="text-center">Semen</td>
                                    <td class="text-center">Tiga Roda</td>
                                    <td class="text-center">1203</td>
                                    <td class="text-center">900</td>
                                    <td class="text-center">Roll</td>
                                    <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-edit"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i class="fa fa-eye"
                                                    data-toggle="modal" data-target="#modalLampiran"></i></button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td class="text-center">Kabel NYM</td>
                                    <td class="text-center">Jembo</td>
                                    <td class="text-center">1203</td>
                                    <td class="text-center">900</td>
                                    <td class="text-center">Roll</td>
                                    <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-edit"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i class="fa fa-eye"
                                                    data-toggle="modal" data-target="#modalLampiran"></i></button></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td class="text-center">Kabel NYM</td>
                                    <td class="text-center">Jembo</td>
                                    <td class="text-center">1203</td>
                                    <td class="text-center">900</td>
                                    <td class="text-center">Roll</td>
                                    <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-edit"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i class="fa fa-eye"
                                                    data-toggle="modal" data-target="#modalLampiran"></i></button></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
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
    <!-- END: Delete Confirmation Modal -->
@endsection


@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }
    </script>
@endsection

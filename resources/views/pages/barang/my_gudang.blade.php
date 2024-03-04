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
            <li class="breadcrumb-item">Data Barang</li>
            <li class="breadcrumb-item active">Gudang Saya</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">List Data Barang Saya</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h5>Lokasi: Gudang Pencahayaan Pulau Tidung</h5>
                            <br>
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalFilter"><i
                                    class="fa fa-filter"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Jenis Barang</th>
                                    <th class="text-center">Tahun Pengadaan</th>
                                    <th class="text-center">Stock Awal</th>
                                    <th class="text-center">Stock Saat Ini</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($barang as $item) --}}
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Semen Tiga Roda</td>
                                    <td class="text-center">Consumable</td>
                                    <td class="text-center">2024</td>
                                    <td class="text-center">220</td>
                                    <td class="text-center">210</td>
                                    <td class="text-center">Zak</td>
                                    <td class="text-center">
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-hand"></i></button></a>
                                        <a href="#"><button class="btn btn-outline-primary"><i
                                                    class="fa fa-eye"></i></button></a>
                                    </td>
                                </tr>
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BEGIN: Filter Modal --}}
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="">Kontrak</label>
                                <select name="kontrak" class="form-control" required>
                                    <option value="" selected disabled>- pilih kontrak -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Barang</label>
                                <select name="jenis_barang" class="form-control" required>
                                    <option value="" selected disabled>- pilih jenis barang -</option>
                                    <option value="consumable">Consumable</option>
                                    <option value="tools">Tools</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="periode">Tahun Pengadaan</label>
                                <select name="periode" class="form-control" required>
                                    <option value="" selected disabled>- pilih periode pengadaan -</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Filter Data</button>
                </div>
            </div>
        </div>
    </div>

    {{-- END: Filter Modal --}}
@endsection


@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }

        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var diceklis = $('input[type="checkbox"]:checked').length > 0;

                if (diceklis) {
                    $('#kirimBarangButton').show();
                } else {
                    $('#kirimBarangButton').hide();
                }
            });
        });
    </script>
@endsection

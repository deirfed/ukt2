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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="javascript:;" title="Filter" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalFilter"><i class="fa fa-filter"></i> Filter</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">No. Resi</th>
                                    <th class="text-center">Asal</th>
                                    <th class="text-center">Tujuan</th>
                                    <th class="text-center">Pengirim</th>
                                    <th class="text-center">Tanggal Kirim</th>
                                    <th class="text-center">Penerima</th>
                                    <th class="text-center">Tanggal Terima</th>
                                    <th class="text-center">Catatan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengiriman_barang as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->no_resi }}</td>
                                        <td class="text-center">Gudang Utama</td>
                                        <td class="text-center">{{ $item->gudang->name }}</td>
                                        <td class="text-center text-wrap">{{ $item->submitter->name }}</td>
                                        <td class="text-center">
                                            {{ $item->tanggal_kirim ?? '-' }}
                                        </td>
                                        <td class="text-center text-wrap">{{ $item->receiver->name ?? '-' }}</td>
                                        <td class="text-center">
                                            {{ $item->tanggal_terima ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->catatan }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->status }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('pengiriman.show', $item->no_resi) }}"
                                                class="btn btn-outline-primary" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
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
                                            <td class="font-bolder" id="noKontrak">
                                                S.5875/DKI
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Nama Barang</td>
                                            <td> : </td>
                                            <td class="font-bolder" id="namaBarang">
                                                Semen Tiga Roda
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td> : </td>
                                            <td class="font-bolder" id="stockAwal">
                                                <span id="satuan"></span>
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


    {{-- BEGIN: BAST Modal Confirmation --}}
    <div id="bast-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="text-3xl mt-2">BAST akan dibuat berdasarkan data yang sudah difilter.</div>
                        <div class="text-slate-500 mt-2">Buat BAST Pengiriman?</div>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <form action="#" method="POST">
                            @csrf
                            @method('delete')
                            <input type="text" name="id" id="id" hidden>
                            <button type="button" data-dismiss="modal"
                                class="btn btn-dark w-24 mr-1 me-2">Batal</button>
                            <button type="submit" class="btn btn-primary w-24">Buat BAST</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: BAST Moal --}}

    {{-- BEGIN: Filter Modal --}}
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter"
        aria-hidden="true">
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
                                <label for="">Status</label>
                                <select name="jenis_barang" class="form-control" required>
                                    <option value="" selected disabled>- pilih status barang -</option>
                                    <option value="consumable">Diproses</option>
                                    <option value="tools">Diterima</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="periode">Periode Pengiriman</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="start" placeholder="start">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="end" placeholder="end">
                                </div>
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
    <script>
        $('#modalLampiran').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var nama = button.data('nama');
            var stock_awal = button.data('stock_awal');
            var no_kontrak = button.data('no_kontrak');

            $('#namaBarang').text(nama);
            $('#noKontrak').text(no_kontrak);
            $('#stockAwal').text(stock_awal);
        });
    </script>
@endsection

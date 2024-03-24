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
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h4>Lokasi: Gudang Seksi {{ $formasi_tim->struktur->seksi->name }} - Pulau
                                {{ $formasi_tim->area->pulau->name ?? '-' }}</h4>
                            <br>
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="javascript:;" class="btn btn-primary" data-toggle="modal" data-target="#modalFilter"><i
                                    class="fa fa-filter"></i> Filter
                            </a>
                            <button type="submit" form="ambil-barang-form" id="ambilBarangButton" class="btn btn-warning"
                                style="display: none;">
                                <i class="fa fa-hand"></i> Ambil Barang
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Pilih</th>
                                    <th class="text-center">Gudang</th>
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
                                <form id="ambil-barang-form" action="{{ route('transaksi.barang.create') }}" method="GET">
                                    @csrf
                                    @method('GET')
                                    @foreach ($barang_pulau as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" name="barang_pulau_id[]" value="{{ $item->id }}">
                                            </td>
                                            <td class="text-center">{{ $item->gudang->name }}</td>
                                            <td class="text-center font-weight-bold">{{ $item->barang->name }}</td>
                                            <td class="text-center">{{ $item->barang->jenis }}</td>
                                            <td class="text-center">{{ $item->barang->kontrak->tanggal }}</td>
                                            <td class="text-center">{{ $item->stock_awal }}</td>
                                            <td class="text-center">{{ $item->stock_aktual }}</td>
                                            <td class="text-center">{{ $item->barang->satuan }}</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-outline-primary" title="Lihat Photo"
                                                    data-toggle="modal" data-target="#modalLampiran"
                                                    data-photo="{{ $item->barang->photo }}"><i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($barang_pulau->count() == 0)
                                        <tr>
                                            <td class="text-center" colspan="10">
                                                Data barang tidak ditemukan, kemungkinan barang belum dikirim atau stock
                                                sudah habis.
                                            </td>
                                        </tr>
                                    @endif
                                </form>
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

    {{-- BEGIN: Lampiran Modal --}}
    <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="modalLampiran"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lampiran Dokumentasi Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="row gutters">
                        <div id="photo_modal" class="container">
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


@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }

        $(document).ready(function() {
            $('input[type="checkbox"]').change(function() {
                var diceklis = $('input[type="checkbox"]:checked').length > 0;

                if (diceklis) {
                    $('#ambilBarangButton').show();
                } else {
                    $('#ambilBarangButton').hide();
                }
            });

            $('#modalLampiran').on('show.bs.modal', function(e) {
                var photoArray = $(e.relatedTarget).data('photo');
                var photoHTML = '';

                photoArray.forEach(function(item) {
                    var photoPath = "{{ asset('storage/') }}" + '/' + item;
                    photoHTML +=
                        '<div class""><img class="img-thumbnail img-fluid" style="width: 400px;" src="' +
                        photoPath + '" alt="photo"></div>';
                });

                document.getElementById("photo_modal").innerHTML = photoHTML;
            });
        });
    </script>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Kinerja | Laporan Kinerja Saya
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Kinerja</li>
            <li class="breadcrumb-item active">Daftar Laporan Kinerja Saya</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    </div>
                    <div class="table-responsive">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a class="btn btn-primary" href="{{ route('kinerja.create') }}">
                                Tambah Data
                            </a>
                            <button data-toggle="modal" data-target="#modalDownloadExcel" title="Export Excel"
                                class="btn btn-primary">
                                <i class="fa fa-file-excel"></i>
                                Export to Excel
                            </button>
                            <a href="javascript:;" title="Filter" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalFilter"><i class="fa fa-filter"></i> Filter</a>
                            <a href="{{ route('kinerja.saya') }}" class="btn btn-primary" title="Reset Filter">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">NIP</th>
                                        <th class="text-center">Koordinator</th>
                                        <th class="text-center">Tim</th>
                                        <th class="text-center">Seksi</th>
                                        <th class="text-center">Pulau</th>
                                        <th class="text-center">Giat/Pekerjaan</th>
                                        <th class="text-center">Lokasi</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kinerja as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->tanggal }}</td>
                                            <td class="text-center">{{ $item->anggota->name }}</td>
                                            <td class="text-center">{{ $item->anggota->nip }}</td>
                                            <td class="text-center">{{ $item->koordinator->name }}</td>
                                            <td class="text-center">{{ $item->tim->name }}</td>
                                            <td class="text-center">{{ $item->seksi->name }}</td>
                                            <td class="text-center">{{ $item->pulau->name }}</td>
                                            <td class="text-center">{{ $item->kategori->name ?? $item->kegiatan }}</td>
                                            <td class="text-center">
                                                {{ $item->lokasi }}
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#detailKinerja" data-photo='{{ $item->photo }}'>
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($kinerja->count() == 0)
                                        <tr>
                                            <td class="text-center" colspan="11">
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

    {{-- BEGIN: Modal Detail --}}
    <div class="modal fade" id="detailKinerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Detail Laporan Kinerja</h5>
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
    {{-- END: Modal Detail --}}

    {{-- BEGIN: Filter Modal --}}
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Kinerja Saya</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter" action="{{ route('kinerja.filter') }}" method="GET">
                        @csrf
                        @method('GET')
                        <input type="text" name="anggota_id" value="{{ auth()->user()->uuid }}" hidden>
                        <label for="periode">Periode</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                        name="start_date" value="{{ $start_date ?? '' }}" class="form-control"
                                        id="start" placeholder="start">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                        class="form-control" value="{{ $end_date ?? '' }}" name="end_date"
                                        id="end" placeholder="end">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button form="formFilter" type="submit" class="btn btn-primary">Filter Data</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Filter Modal --}}

    {{-- BEGIN: Konfirmasi Excel --}}
    <div id="modalDownloadExcel" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="mt-2 fw-bolder">Apakah anda yakin?</div>
                        <div class="mt-2">
                            <img style="height: 100px;"
                                src="https://i.pinimg.com/originals/1b/db/8a/1bdb8ac897512116cbac58ffe7560d82.png"
                                alt="PDF">
                        </div>
                        <div class="text-slate-500 mt-2">
                            <p>
                                Data ini akan di-generate dalam format Excel!
                            </p>
                        </div>
                        <form id="exportExcel" action="{{ route('kinerja.excel') }}" method="GET" hidden>
                            @csrf
                            @method('GET')
                            <input type="text" name="anggota_id" value={{ auth()->user()->uuid }}>
                            <input type="text" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="text" name="end_date" value="{{ $end_date ?? '' }}">
                        </form>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <button type="submit" form="exportExcel" formtarget="_blank"
                            class="btn btn-primary w-24 mr-1 me-2">Download</button>
                        <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi Excel --}}
@endsection


@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#detailKinerja').on('show.bs.modal', function(e) {
                var photoArray = $(e.relatedTarget).data('photo');
                console.log(Array.isArray(photoArray));
                var photoHTML = '';

                photoArray.forEach(function(item) {
                    var photoPath = "{{ asset('storage/') }}" + '/' + item;
                    photoHTML +=
                        '<div class""><img class="img-thumbnail img-fluid" style="width: 400px;" src="' +
                        photoPath + '" alt="photo"></div>';
                    console.log(photoPath);
                });

                document.getElementById("photo_modal").innerHTML = photoHTML;
            });
        });
    </script>
@endsection

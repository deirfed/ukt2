@extends('layout.base')

@section('title-head')
    <title>
        Kinerja | Daftar Laporan Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Kinerja</li>
            <li class="breadcrumb-item active">Daftar Laporan Kinerja</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Laporan Kinerja</div>
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
                            <button data-toggle="modal" data-target="#modalDownloadExcel" title="Export Excel"
                                class="btn btn-primary">
                                <i class="fa fa-file-excel"></i>
                                Export to Excel
                            </button>
                            <a href="javascript:;" title="Filter" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalFilter"><i class="fa fa-filter"></i> Filter</a>
                            <a href="{{ route('kinerja.index') }}" class="btn btn-primary" title="Reset Filter">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">No. Tiket</th>
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
                                            <td class="text-center">{{ $item->ticket_number }}</td>
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
                                            <td class="text-center" colspan="12">
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
                    <h5 class="modal-title">Filter Data Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter" action="{{ route('kinerja.filter') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="pulau_id">Pulau</label>
                                    <select name="pulau_id" id="pulau_id" class="form-control">
                                        <option value="" selected disabled>- pilih pulau -</option>
                                        @foreach ($pulau as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $pulau_id ?? '') selected @endif>Pulau {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="seksi_id">Seksi</label>
                                    <select name="seksi_id" id="seksi_id" class="form-control">
                                        <option value="" selected disabled>- pilih seksi -</option>
                                        @foreach ($seksi as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $seksi_id ?? '') selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="koordinator_id">Koordinator</label>
                                    <select name="koordinator_id" id="koordinator_id" class="form-control">
                                        <option value="" selected disabled>- pilih koordinator -</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tim_id">Tim</label>
                                    <select name="tim_id" id="tim_id" class="form-control">
                                        <option value="" selected disabled>- pilih tim -</option>
                                        @foreach ($tim as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $tim_id ?? '') selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
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
                    <button type="submit" form="formFilter" class="btn btn-primary">Filter Data</button>
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
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="seksi_id" value="{{ $seksi_id ?? '' }}">
                            <input type="text" name="koordinator_id" value="{{ $koordinator_id ?? '' }}">
                            <input type="text" name="tim_id" value="{{ $tim_id ?? '' }}">
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

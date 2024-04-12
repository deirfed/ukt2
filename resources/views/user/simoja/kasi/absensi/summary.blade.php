@extends('layout.base_user')

@section('title-head')
    <title>
        Absensi | Ringkasan Absensi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.kasi.index') }}">Absensi</a></li>
            <li class="breadcrumb-item active">Daftar Absensi Seksi {{ auth()->user()->struktur->seksi->name }}</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex justify-content-center mb-3 text-center" style="text-decoration: underline">Rekap
                        Absensi - Seksi {{ auth()->user()->struktur->seksi->name }}</h4>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <div class="d-flex justify-content-start align-items-center flex-wrap">
                                <a href="{{ route('simoja.kasi.absensi') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                                <a href="javascript:;" class="btn btn-primary mr-2 mb-2 mb-sm-0" data-toggle="modal"
                                    data-target="#modalFilter" title="Filter"><i class="fa fa-filter"></i></a>
                                <a href="{{ route('simoja.kasi.absensi.ringkasan') }}"
                                    class="btn btn-primary mr-2 mb-2 mb-sm-0" title="Reset Filter">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                <div class="mr-2 mb-2 mb-sm-0 nav-item dropdown">
                                    <button class="btn btn-primary mr-2 mb-2 mb-sm-0 nav-link text-white" href="#"
                                        id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" title="Export">
                                        <i class="fa fa-paper-plane"></i> Export
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
                                        <li>
                                            <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                data-target="#modalDownloadExcel" title="Filter">
                                                <i class="fa fa-file-excel text-primary"></i> Export Excel
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                data-target="#modalDownloadPDF">
                                                <i class="fa fa-file-pdf text-danger"></i> Export PDF
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <form class="form-inline mb-2 d-flex justify-content-end">
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
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">NIP</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Pulau</th>
                                    <th class="text-center">Jumlah Hari Kerja</th>
                                    <th class="text-center">Jumlah Hadir</th>
                                    <th class="text-center">Jumlah Izin</th>
                                    <th class="text-center">Jumlah Mangkir</th>
                                    <th class="text-center">Total Jam Kerja</th>
                                    <th class="text-center">Persentase Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->user->nip }}</td>
                                        <td>{{ $item->user->jabatan->name }}</td>
                                        <td>{{ $item->user->area->pulau->name }}</td>
                                        <td></td>
                                        <td>{{ $item->total_hari_absen }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                {{-- @foreach ($absensi as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center font-weight-bold">{{ $item->user->name }}</td>
                                        <td class="text-center">{{ $item->user->jabatan->name }}</td>
                                        <td class="text-center">Pulau {{ $item->user->area->pulau->name }}</td>
                                        <td class="text-center">{{ $item->jam_masuk ?? '-' }}</td>
                                        <td class="text-center">
                                            <div
                                                class="@if ($item->telat_masuk > 0) badge badge-pill badge-warning @else @endif">
                                                {{ $item->status_masuk ?? '-' }} <br>
                                                {{ $item->telat_masuk > 0 ? $item->telat_masuk . ' menit' : '' }}
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->jam_pulang ?? '-' }}</td>
                                        <td class="text-center">
                                            <div
                                                class="@if ($item->cepat_pulang > 0) badge badge-pill badge-warning @else @endif">
                                                {{ $item->status_pulang ?? '-' }} <br>
                                                {{ $item->cepat_pulang > 0 ? $item->cepat_pulang . ' menit' : '' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div
                                                class="@if ($item->status == 'Tidak Absen Datang') badge badge-pill badge-danger @else badge badge-pill badge-primary @endif">
                                                {{ $item->status }}
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            <span class="font-weight-bold">Datang: </span>{{ $item->catatan_masuk ?? '-' }}
                                            <br>
                                            <span class="font-weight-bold">Pulang:
                                            </span>{{ $item->catatan_pulang ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="#" data-toggle="modal" data-target="#modalDokumentasi"
                                                data-photo_masuk='{{ asset('storage/' . $item->photo_masuk) }}'
                                                data-photo_pulang='{{ asset('storage/' . $item->photo_pulang) }}'><button
                                                    class="btn btn-outline-primary"><i class="fa fa-eye"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($absensi->count() == 0)
                                    <td class="text-center" colspan="12">
                                        Tidak ada data.
                                    </td>
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- START: FILTER ABSENSI --}}
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Absensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter" action="{{ route('simoja.kasi.absensi.filter') }}" method="GET">
                        @csrf
                        @method('GET')
                        <label for="periode">Periode</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="" name="start_date">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="" name="end_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Urutan</label>
                                    <select name="sort" class="form-control">
                                        {{-- <option value="ASC" @if ($sort == 'ASC') selected @endif>A to Z
                                        </option>
                                        <option value="DESC" @if ($sort == 'DESC') selected @endif>Z to A
                                        </option> --}}
                                    </select>
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
    {{-- END: FILTER ABSENSI --}}

    {{-- START: MODAL DOKUMENTASI --}}
    <div class="modal fade" id="modalDokumentasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAdminTitle">Dokumentasi Absensi</h4>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="mb-4 text-center align-middle">
                            <div class="border mx-auto" style="width: 70%">
                                <p class="fw-bolder mb-0">Dokumentasi Masuk</p>
                                <img src="#" id="photo_masuk_modal" class="img-thumbnail"
                                    alt="Tidak ada dokumentasi absen masuk">
                            </div>
                        </div>
                        <div class="mb-4 text-center align-middle">
                            <div class="border mx-auto" style="width: 70%">
                                <p class="fw-bolder mb-0">Dokumentasi Pulang</p>
                                <img src="#" id="photo_pulang_modal" class="img-thumbnail"
                                    alt="Belum ada dokumentasi absen pulang">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END: MODAL DOKUMENTASI --}}

    {{-- BEGIN: Konfirmasi Excel --}}
    <div id="modalDownloadExcel" class="modal fade" tabindex="-1" aria-hidden="true">
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
                        <form id="exportExcel" action="{{ route('simoja.kasi.absensi.export.excel') }}" method="GET"
                            hidden>
                            @csrf
                            @method('GET')
                            {{-- <input type="text" name="user_id" value="{{ $user_id ?? '' }}">
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="text" name="end_date" value="{{ $end_date ?? '' }}">
                            <input type="text" name="sort" value="{{ $sort ?? 'ASC' }}"> --}}
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="exportExcel" formtarget="_blank" class="btn btn-primary">Unduh</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi Excel --}}

    {{-- BEGIN: Konfirmasi PDF --}}
    <div id="modalDownloadPDF" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="formPDF" action="{{ route('simoja.kasi.absensi.export.pdf') }}" method="GET">
                        @csrf
                        @method('GET')
                        <label for="periode">Periode</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="" name="start_date"
                                        required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="" name="end_date" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="formPDF" formtarget="_blank" class="btn btn-primary">Buat</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi PDF --}}
@endsection


@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }

        $(document).ready(function() {
            $('#modalDokumentasi').on('show.bs.modal', function(e) {
                var photoMasuk = $(e.relatedTarget).data('photo_masuk');
                var photoPulang = $(e.relatedTarget).data('photo_pulang');

                document.getElementById("photo_masuk_modal").src = photoMasuk;
                document.getElementById("photo_pulang_modal").src = photoPulang;
            });
        });
    </script>
@endsection

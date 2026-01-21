@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Superadmin | Data Absensi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Arsip Data</li>
            <li class="breadcrumb-item active">Data Absensi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="task-section">
                <div class="row no-gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="d-md-none mb-2 mt-2 text-center">
                            <button class="btn btn-primary px-4" type="button" data-toggle="collapse"
                                data-target="#arsipTahunMobile">
                                ☰ Arsip Tahun
                            </button>
                        </div>
                    </div>
                    <div class="col-12 d-md-none">
                        <div class="collapse" id="arsipTahunMobile">
                            <div class="card mb-3">
                                <div class="card-body p-2">
                                    <div class="list-group list-group-flush">
                                        @foreach ($tahuns as $y)
                                            <a href="{{ route('admin-absensi.index', ['tahun' => $y]) }}"
                                                class="list-group-item list-group-item-action {{ $y == $tahun ? 'active' : '' }}">
                                                <i class="icon-receipt"></i> {{ $y }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-4">
                        <div class="labels-container collapse d-md-block" id="arsipTahun">
                            <div class="mt-5"></div>
                            <div class="lablesContainerScroll">
                                <div class="filters-block">
                                    <h5><u>Arsip Tahun</u></h5>
                                    <div class="filters">
                                        @foreach ($tahuns as $y)
                                            <a href="{{ route('admin-absensi.index', ['tahun' => $y]) }}"
                                                class="{{ $y == $tahun ? 'active' : '' }}">
                                                <i class="icon-receipt"></i>
                                                {{ $y }}
                                                @if ($y == date('Y'))
                                                    (Tahun Berjalan)
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="d-flex justify-content-center mb-3 text-center"
                                    style="text-decoration: underline">Rekap
                                    Absensi - PJLP UKT 2</h4>
                                <h4 class="d-flex justify-content-center mb-3 text-center"
                                    style="text-decoration: underline" id="absensi-title">Tahun {{ $tahun }}</h4>
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                                        <div class="d-flex justify-content-start align-items-center flex-wrap">
                                            <a href="{{ route('dashboard.index') }}"
                                                class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i
                                                    class="fa fa-arrow-left"></i>
                                                Kembali</a>
                                            <a href="javascript:;" class="btn btn-primary mr-2 mb-2 mb-sm-0"
                                                data-toggle="modal" data-target="#modalFilter" title="Filter"><i
                                                    class="fa fa-filter"></i></a>
                                            <a href="{{ route('admin-absensi.index') }}"
                                                class="btn btn-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-refresh"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-primary mr-2 mb-2 mb-sm-0 text-white"
                                                    id="exportDropdown" role="button" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false" title="Export">
                                                    <i class="fa fa-paper-plane"></i> Export
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                            data-target="#modalDownloadExcel" title="Export Excel">
                                                            <i class="fa fa-file-excel text-primary"></i> Export Excel
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                            data-target="#modalDownloadPDF" title="Export PDF">
                                                            <i class="fa fa-file-pdf text-danger"></i> Export PDF
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    {{ $dataTable->table([
                                        'class' => 'table table-bordered table-striped',
                                    ]) }}
                                </div>
                            </div>
                        </div>
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
                    <form id="formFilter" action="{{ route('admin-absensi.index') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Seksi</label>
                                    <select name="seksi_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Seksi -</option>
                                        @foreach ($seksi as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == $seksi_id)>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Personel</label>
                                    <select name="user_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Personel -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $user_id) selected @endif>{{ $item->name }} -
                                                {{ $item->nip ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Pulau</label>
                                    <select name="pulau_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Pulau -</option>
                                        @foreach ($pulau as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $pulau_id) selected @endif>Pulau {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <label for="periode">Bulan & Tahun</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="bulan" id="bulan" required>
                                        @for ($m = 1; $m <= 12; $m++)
                                            @php
                                                $val = str_pad($m, 2, '0', STR_PAD_LEFT);
                                            @endphp
                                            <option value="{{ $val }}" @selected($val == $bulan)>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <select class="form-control" name="tahun" id="tahun" required>
                                        @foreach ($tahuns as $y)
                                            <option value="{{ $y }}" @selected($y == $tahun)>
                                                {{ $y }}</option>
                                        @endforeach
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
                            <input type="text" name="seksi_id" value="{{ $seksi_id ?? '' }}">
                            <input type="text" name="user_id" value="{{ $user_id ?? '' }}">
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="text" name="end_date" value="{{ $end_date ?? '' }}">
                            <input type="text" name="sort" value="{{ $sort ?? 'ASC' }}">
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
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Personel</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" selected disabled>- Pilih Personel -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $user_id) selected @endif>{{ $item->name }} -
                                                {{ $item->nip ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <input type="month" class="form-control" name="periode"
                                        value="{{ $periode }}">
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
@endsection


@push('scripts')
    {{ $dataTable->scripts() }}
@endpush


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

        document.addEventListener("DOMContentLoaded", function() {
            const yearLinks = document.querySelectorAll(".year-link");

            yearLinks.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    let year = this.dataset.year;

                    document.getElementById("absensi-title").innerHTML = 'Tahun ' + year;

                    yearLinks.forEach(l => l.classList.remove("active"));

                    this.classList.add("active");
                });
            });
        });
    </script>
@endsection

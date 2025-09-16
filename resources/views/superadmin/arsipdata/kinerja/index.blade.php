@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Superadmin | Data Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Arsip Data</li>
            <li class="breadcrumb-item active">Data Kinerja</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="task-section">
                <div class="row no-gutters">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-4">
                        <div class="labels-container">
                            <div class="mt-5"></div>
                            <div class="lablesContainerScroll">
                                <div class="filters-block">
                                    <h5>Arsip Tahun</h5>
                                    <div class="filters">
                                        @foreach ($tahuns as $y)
                                            <a href="{{ route('admin-kinerja.index', ['tahun' => $y]) }}"
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
                    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="d-flex justify-content-center mb-3 text-center"
                                    style="text-decoration: underline">Rekap
                                    Kinerja - PJLP UKT 2</h4>
                                <h4 class="d-flex justify-content-center mb-3 text-center"
                                    style="text-decoration: underline" id="kinerja-title">Tahun {{ $tahun }}</h4>
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
                                            <a href="{{ route('admin-kinerja.index') }}"
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
                                                            data-target="#modalDownloadPDFAll">
                                                            <i class="fa fa-file-pdf text-danger"></i> PDF
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                            data-target="#modalDownloadPDF">
                                                            <i class="fa fa-file-pdf text-danger"></i> PDF per Personil
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                            data-target="#modalDownloadPDFKegiatan">
                                                            <i class="fa fa-file-pdf text-danger"></i> PDF per Kegiatan
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

    {{-- START: FILTER KINERJA --}}
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Kinerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter" action="{{ route('admin-kinerja.index') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Seksi</label>
                                    <select name="seksi_id" class="form-control" required>
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
                                <div class="form-group">
                                    <label for="">Kegiatan</label>
                                    <select name="kategori_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Kegiatan -</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == $kategori_id)>
                                                ({{ $item->seksi->name ?? '#' }}) - {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <input type="text" class="form-control" name="tahun" value="{{ $tahun }}" readonly>
                                </div>
                            </div>
                        </div>
                        <label for="periode">Tanggal & Bulan</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $start_date }}"
                                        name="start_date" id="start_date" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $end_date }}"
                                        name="end_date" id="end_date" required>
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
    {{-- END: FILTER KINERJA --}}

    {{-- START: MODAL DOKUMENTASI --}}
    <div class="modal fade" id="modalDokumentasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAdminTitle">Dokumentasi Pekerjaan</h4>
                </div>
                <div class="modal-body">
                    <div class="mb-4 text-center align-middle">
                        <div class="border mx-auto" style="width: 70%">
                            <p class="fw-bolder mb-0">Dokumentasi Pekerjaan</p>
                            <div id="photo_modal" class="container"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                        Tutup
                    </button>
                </div>
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
                        <form id="exportExcel" action="{{ route('simoja.kasi.kinerja.export.excel') }}" method="GET"
                            hidden>
                            @csrf
                            @method('GET')
                            <input type="text" name="seksi_id" value="{{ $seksi_id ?? '' }}">
                            <input type="text" name="user_id" value="{{ $user_id ?? '' }}">
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="kategori_id" value="{{ $kategori_id ?? '' }}">
                            <input type="text" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="text" name="end_date" value="{{ $end_date ?? '' }}">
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
                    <form id="formPDF" action="{{ route('simoja.kasi.kinerja.export.pdf') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Personil</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" selected disabled>- Pilih Personil -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $user_id) selected @endif>{{ $item->name }} -
                                                {{ $item->nip ?? '-' }}
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
                                    <input type="date" class="form-control" value="{{ $start_date }}"
                                        name="start_date" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $end_date }}"
                                        name="end_date" required>
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

    {{-- BEGIN: Konfirmasi PDF Kegiatan --}}
    <div id="modalDownloadPDFKegiatan" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="formKegiatanPDF" action="{{ route('simoja.kasi.kinerja.export.pdf.kegiatan') }}"
                        method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Kegiatan</label>
                                    <select name="kategori_id" class="form-control" required>
                                        <option value="" selected disabled>- Pilih Kegiatan -</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}" @selected($item->id == $kategori_id)>
                                                ({{ $item->seksi->name ?? '#' }}) - {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Personil</label>
                                    <select name="user_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Personil (opsional) -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $user_id) selected @endif>{{ $item->name }} -
                                                {{ $item->nip ?? '-' }}
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
                                    <input type="date" class="form-control" value="{{ $start_date }}"
                                        name="start_date" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $end_date }}"
                                        name="end_date" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="formKegiatanPDF" formtarget="_blank"
                        class="btn btn-primary">Buat</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi PDF Kegiatan --}}

    {{-- BEGIN: Konfirmasi PDF All --}}
    <div id="modalDownloadPDFAll" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="mt-2 fw-bolder">Apakah anda yakin?</div>
                        <div class="mt-2">
                            <img style="height: 100px;"
                                src="https://static.vecteezy.com/system/resources/previews/019/016/806/non_2x/adobe-acrobat-reader-icon-free-png.png"
                                alt="PDF">
                        </div>
                        <div class="text-slate-500 mt-2">
                            <p>
                                Data ini akan di-generate dalam format PDF!
                            </p>
                        </div>
                        <form id="formKegiatanPDFAll" action="{{ route('simoja.kasi.kinerja.export.pdf.all') }}" method="GET"
                            hidden>
                            @csrf
                            @method('GET')
                            <input type="text" name="seksi_id" value="{{ $seksi_id ?? '' }}">
                            <input type="text" name="user_id" value="{{ $user_id ?? '' }}">
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="kategori_id" value="{{ $kategori_id ?? '' }}">
                            <input type="text" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="text" name="end_date" value="{{ $end_date ?? '' }}">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="formKegiatanPDFAll" formtarget="_blank"
                        class="btn btn-primary">Unduh</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi PDF All --}}
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#modalDokumentasi').on('show.bs.modal', function(e) {
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

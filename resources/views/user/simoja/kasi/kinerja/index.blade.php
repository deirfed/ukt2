@extends('layout.base_user')

@section('title-head')
    <title>
        Kinerja | Daftar Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.kasi.index') }}">Kinerja</a></li>
            <li class="breadcrumb-item active">Daftar Laporan Kinerja Seksi {{ auth()->user()->struktur->seksi->name }}</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex justify-content-center mb-3 text-center" style="text-decoration: underline">Rekap
                        Kinerja - Seksi {{ auth()->user()->struktur->seksi->name }}</h4>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <div class="d-flex justify-content-start align-items-center flex-wrap">
                                <a href="{{ route('simoja.kasi.index') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                                <a href="javascript:;" class="btn btn-primary mr-2 mb-2 mb-sm-0" data-toggle="modal"
                                    data-target="#modalFilter" title="Filter"><i class="fa fa-filter"></i></a>
                                <button class="btn btn-primary mr-2 mb-2 mb-sm-0 text-white" href="#"
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
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <form class="form-inline mb-2 d-flex justify-content-end">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                    </div>
                    <div class="paginate-style">
                        <div class="d-flex justify-content-center mb-2">
                            <a href="{{ route('simoja.kasi.kinerja') }}" class="btn btn-primary mr-2 mb-2 mb-sm-0"><i
                                    class="fa fa-refresh"></i>
                            </a>
                            <div class="dropdown mr-2">
                                <button class="btn btn-primary mr-2 mb-2 mb-sm-0" id="displayDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Tampil Data">
                                    <i class="fa fa-list"></i> Tampil Data
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="displayDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#" title="Show 50">
                                            <i class="fa fa-list text-primary"></i> 50
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" title="Show 100">
                                            <i class="fa fa-list text-primary"></i> 100
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" title="Show 200">
                                            <i class="fa fa-list text-primary"></i> 200
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <nav aria-label="Pagination">
                                <ul class="pagination">
                                    {{ $kinerja->links('vendor.pagination.bootstrap-4') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Pulau</th>
                                    <th class="text-center">Koordinator</th>
                                    <th class="text-center">Giat</th>
                                    <th class="text-center">Deskripsi</th>
                                    <th class="text-center">Lokasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kinerja as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                        <td class="text-center font-weight-bold">{{ $item->anggota->name ?? '-' }}</td>
                                        <td class="text-center">Pulau {{ $item->formasi_tim->area->pulau->name }}</td>
                                        <td class="text-center">{{ $item->koordinator->name ?? '-' }}</td>
                                        <td class="text-center">{{ $item->kategori->name ?? $item->kegiatan }}</td>
                                        <td class="text-center">{{ $item->deskripsi ?? '-' }}</td>
                                        <td class="text-center">{{ $item->lokasi ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="#" data-toggle="modal" data-target="#modalDokumentasi"
                                                data-photo='{{ $item->photo }}'><button
                                                    class="btn btn-outline-primary"><i class="fa fa-eye"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($kinerja->count() == 0)
                                    <tr>
                                        <td class="text-center" colspan="9">
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

    {{-- START: FILTER KINERJA --}}
    <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Kinerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter" action="{{ route('simoja.kasi.kinerja.filter') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                        <label for="periode">Periode</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $start_date }}"
                                        name="start_date">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $end_date }}"
                                        name="end_date">
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Urutan</label>
                                    <select name="sort" class="form-control">
                                        <option value="ASC" @if ($sort == 'ASC') selected @endif>A to Z
                                        </option>
                                        <option value="DESC" @if ($sort == 'DESC') selected @endif>Z to A
                                        </option>
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
                    <form id="formPDF" action="{{ route('simoja.kasi.kinerja.export.pdf') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                            </div> --}}
                            <div class="container text-center my-5">
                                <h4>Fitur ini masih dalam tahap pengembangan</h4>
                            </div>
                        </div>
                        {{-- <label for="periode">Periode</label>
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
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    {{-- <button type="submit" form="formPDF" formtarget="_blank" class="btn btn-primary">Buat</button> --}}
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

        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);

            document.querySelectorAll('.jam').forEach(function(element) {
                element.innerHTML = h + ":" + m + ":" + s;
            });

            setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            };
            return i;
        }

        $(document).ready(function() {
            startTime();

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

        var route = "{{ route('simoja.kasi.kinerja') }}";

        var dropdownItems = document.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(function(item) {
            item.addEventListener('click', function(event) {
                event.preventDefault();

                var selectedValue = this.innerText.trim();
                switch (selectedValue) {
                    case '50':
                        window.location.href = route + "?perHalaman=50";
                        break;
                    case '100':
                        window.location.href = route + "?perHalaman=100";
                        break;
                    case '200':
                        window.location.href = route + "?perHalaman=200";
                        break;
                    default:
                        console.log('Invalid selection');
                        break;
                }
            });
        });
    </script>
@endsection

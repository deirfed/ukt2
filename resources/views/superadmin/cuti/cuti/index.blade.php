@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Cuti | Data Pengajuan Cuti / Izin
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Cuti</li>
            <li class="breadcrumb-item active">Data Pengajuan Cuti</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card h-250">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary"><i
                                class="fa fa-arrow-left"></i> Kembali</a>
                            <button data-toggle="modal" data-target="#modalDownloadExcel" title="Export Excel"
                                class="btn btn-primary">
                                <i class="fa fa-file-excel"></i>
                                Export to Excel
                            </button>
                            <a href="javascript:;" title="Filter" class="btn btn-primary" data-toggle="modal"
                                data-target="#modalFilter"><i class="fa fa-filter"></i> Filter</a>
                            <a href="{{ route('admin-cuti.index') }}" class="btn btn-primary" title="Reset Filter">
                                <i class="fa fa-refresh"></i>
                            </a>
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

    {{-- BEGIN: Filter Modal --}}
    {{-- <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="modalFilter" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Data Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formFilter" action="{{ route('admin-cuti.index') }}" method="GET">
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
                                        @foreach ($koordinator as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $koordinator_id ?? '') selected @endif>{{ $item->name }} (NIP.
                                                {{ $item->nip }})</option>
                                        @endforeach
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
                                <div class="form-group">
                                    <label for="status">Status Cuti</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" selected disabled>- pilih status -</option>
                                        <option value="Diproses" @if ($status ?? '' == 'Diproses') selected @endif>
                                            Diproses</option>
                                        <option value="Diterima" @if ($status ?? '' == 'Diterima') selected @endif>
                                            Diterima</option>
                                        <option value="Ditolak" @if ($status ?? '' == 'Ditolak') selected @endif>Ditolak
                                        </option>
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
    </div> --}}
    {{-- END: Filter Modal --}}

    {{-- START: FILTER CUTI --}}
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
                    <form id="formFilter" action="{{ route('admin-cuti.index') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
                                    <label for="">Jenis Cuti</label>
                                    <select name="jenis_cuti_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Jenis Cuti -</option>
                                        @foreach ($jenis_cuti as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($jenis_cuti_id == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="" selected disabled>- Pilih Status -</option>
                                        <option value="Diproses" @if ($status == 'Diproses') selected @endif>Diproses
                                        </option>
                                        <option value="Diterima" @if ($status == 'Diterima') selected @endif>
                                            Diterima
                                        </option>
                                        <option value="Ditolak" @if ($status == 'Ditolak') selected @endif>Ditolak
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
    {{-- END: FILTER CUTI --}}

    {{-- BEGIN: Detail Pengajuan Cuti --}}
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
    {{-- END: Pengajuan Cuti --}}

    {{-- BEGIN: Konfirmasi PDF --}}
    <div id="modalDownloadPDF" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="mt-2 fw-bolder">Apakah anda yakin?</div>
                        <div class="mt-2">
                            <img style="height: 100px;" src="https://cdn-icons-png.flaticon.com/256/337/337946.png"
                                alt="PDF">
                        </div>
                        <div class="text-slate-500 mt-2">
                            <p>
                                Data ini akan di-generate dalam format PDF!
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <a id="downloadPDF" href="#" target="_blank"
                            class="btn btn-primary w-24 mr-1 me-2">Download</a>
                        <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi PDF --}}

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
                        <form id="exportExcel" action="{{ route('simoja.kasi.cuti.export.excel') }}" method="GET" hidden>
                            @csrf
                            @method('GET')
                            <input type="text" name="seksi_id" value="{{ $seksi_id ?? '' }}">
                            <input type="text" name="user_id" value="{{ $user_id ?? '' }}">
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="start_date" value="{{ $start_date ?? '' }}">
                            <input type="text" name="end_date" value="{{ $end_date ?? '' }}">
                            <input type="text" name="status" value="{{ $status ?? '' }}">
                            <input type="text" name="jenis_cuti_id" value="{{ $jenis_cuti_id ?? '' }}">
                            <input type="text" name="sort" value="{{ $sort ?? 'ASC' }}">
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

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#modalLampiran').on('show.bs.modal', function(e) {
                var lampiran = $(e.relatedTarget).data('lampiran');
                document.getElementById("photoLampiran").src = lampiran;
            });

            $('#modalDownloadPDF').on('show.bs.modal', function(e) {
                var href = $(e.relatedTarget).data('href');
                console.log(href);
                document.getElementById("downloadPDF").href = href;
            });
        });
    </script>
@endsection

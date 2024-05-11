@extends('layout.base_user')

@section('title-head')
    <title>
        Absensi | Daftar Cuti Tim Saya
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.koordinator.index') }}">Cuti</a></li>
            <li class="breadcrumb-item active">Daftar Cuti Tim Saya</li>

    </div>
@endsection
@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card h-250">
                <div class="card-body">
                    <h4 class="d-flex justify-content-center mb-3 text-center" style="text-decoration: underline">Pengajuan
                        Cuti Tim
                        Saya
                    </h4>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <div class="d-flex justify-content-start align-items-center flex-wrap">
                                <a href="{{ route('simoja.koordinator.index') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                                {{-- <button class="btn btn-primary mr-2 mb-2 mb-sm-0">Export to Excel</button>
                                <button class="btn btn-primary mr-2 mb-2 mb-sm-0">Export to PDF</button> --}}
                                {{-- <a href="" class="btn btn-primary mb-2 mb-sm-0" data-toggle="modal"
                                    data-target="#modalFilter"><i class="fa fa-filter"></i></a> --}}
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <form class="form-inline mb-2 d-flex justify-content-end">
                                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                    </div>
                    <div class="paginate-style">
                        <div class="d-flex justify-content-center mb-2">
                            <a href="{{ route('simoja.koordinator.cuti.tim') }}"
                                class="btn btn-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-refresh"></i>
                            </a>
                            {{-- <nav aria-label="Pagination">
                                <ul class="pagination">
                                    {{ $cuti->links('vendor.pagination.bootstrap-4') }}
                                </ul>
                            </nav> --}}
                        </div>
                    </div>
                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center text-wrap">Nama</th>
                                            <th class="text-center text-wrap">Tanggal Pengajuan </th>
                                            <th class="text-center text-wrap">Jenis Izin</th>
                                            <th class="text-center text-wrap">Jumlah Hari</th>
                                            <th class="text-center text-wrap">Diketahui</th>
                                            <th class="text-center text-wrap">Disetujui</th>
                                            <th class="text-center text-wrap">Status</th>
                                            <th class="text-center text-wrap">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuti as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center text-wrap">
                                                    {{ $item->tanggal_awal == $item->tanggal_akhir ? date('d-m-Y', strtotime($item->tanggal_awal)) : date('d-m-Y', strtotime($item->tanggal_awal)) . ' - ' . date('d-m-Y', strtotime($item->tanggal_akhir)) }}
                                                </td>
                                                <td class="text-center">{{ $item->jenis_cuti->name }}</td>
                                                <td class="text-center">{{ $item->jumlah }} hari</td>
                                                <td class="text-center">
                                                    {{ $item->known_by->name }} <br>
                                                    ({{ $item->known_by->jabatan->name }})
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->status == 'Diterima')
                                                        {{ $item->approved_by->name }} <br>
                                                        ({{ $item->approved_by->jabatan->name }})
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="btn @if ($item->status == 'Diproses') btn-warning @elseif ($item->status == 'Ditolak') btn-secondary @else btn-primary @endif">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->status == 'Diterima')
                                                        <a href="javascript:;" class="btn btn-outline-primary"
                                                            title="Print" title="Download PDF" data-toggle="modal"
                                                            data-target="#modalDownloadPDF"
                                                            data-href="{{ route('cuti.pdf', $item->uuid) }}">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @endif
                                                    <a href="javascript:;" class="btn btn-outline-primary"
                                                        title="Lihat lampiran" data-toggle="modal"
                                                        data-target="#modalDetailPengajuan"
                                                        data-lampiran="{{ $item->lampiran != null ? asset('storage/' . $item->lampiran) : 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg' }}"
                                                        data-nama="{{ $item->user->name }}"
                                                        data-jenis_cuti="{{ $item->jenis_cuti->name }} ({{ $item->jumlah }} hari)"
                                                        data-koordinator="{{ $item->known_by->name }}"
                                                        data-periode="{{ $item->tanggal_awal }} s/d {{ $item->tanggal_akhir }}"
                                                        data-tim="{{ $item->user->struktur->tim->name }} (Pulau {{ $item->user->area->pulau->name }})"
                                                        data-catatan="{{ $item->catatan }}"
                                                        data-status="@if ($item->status == 'Diproses') <h5>*Pengajuan Cuti masih Dalam Proses persetujuan</h5>
                                                        @elseif($item->status == 'Ditolak')
                                                            <h5>*Pengajuan Cuti <span style='color: red'>Ditolak</span>
                                                        @else
                                                            <h5>*Pengajuan Cuti Sudah <span style='color: green'>Disetujui</span> pada Tanggal {{ $item->updated_at }}</h5> @endif">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @if ($item->status == 'Diproses' or $item->status == 'Ditolak')
                                                        <a href="javascript:;" class="btn btn-outline-secondary"
                                                            title="Hapus" data-toggle="modal" data-target="#deleteModal"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($cuti->count() == 0)
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
        </div>
    </div>

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
                    <form id="formFilter" action="{{ route('cuti.filter') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="pulau_id">Personel</label>
                                    <select name="pulau_id" id="pulau_id" class="form-control">
                                        <option value="" selected disabled>- Pilih Personel -</option>
                                        {{-- @foreach ($pulau as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $pulau_id ?? '') selected @endif>Pulau {{ $item->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status Cuti</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" selected disabled>- Pilih Status -</option>
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
    </div>
    {{-- END: Filter Modal --}}

    {{-- START: Modal Detail Pengajuan --}}
    <div class="modal fade" id="modalDetailPengajuan" tabindex="-1" role="dialog"
        aria-labelledby="modalDetailPengajuan" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengajuan Cuti</h5>
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
                    <div class="form-row gutters">
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="nama">Nama Pemohon Cuti</label>
                                <input type="text" class="form-control" id="nama" placeholder="Nama"
                                    value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="koordinator">Koordinator</label>
                                <input type="text" class="form-control" id="koordinator" placeholder="Koordinator"
                                    value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tim">Tim</label>
                                <input type="text" class="form-control" id="tim" placeholder="Tim"
                                    value="" disabled>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="seksi">Jenis Pengajuan</label>
                                <input type="text" class="form-control" id="jenis_cuti" placeholder="Seksi"
                                    value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="periode">Periode Permohonan Cuti</label>
                                <input type="text" class="form-control" id="periode" placeholder="periode"
                                    value="" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ciTy">Deskripsi</label>
                                <input type="text" class="form-control" id="catatan" placeholder="Deskripsi"
                                    value="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row-modal-user gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="status">
                            {{-- <h5>*Pengajuan Cuti masih Dalam Proses persetujuan</h5>
                            <h5>*Pengajuan Cuti Sudah <span style="color: green">Disetujui</span> pada Tanggal 29/01/2024
                            </h5>
                            <h5>*Pengajuan Cuti <span style="color: red">Ditolak</span> --}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Modal Detail Pengajuan --}}

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
                        <form id="exportExcel" action="{{ route('cuti.excel') }}" method="GET" hidden>
                            @csrf
                            @method('GET')
                            <input type="text" name="pulau_id" value="{{ $pulau_id ?? '' }}">
                            <input type="text" name="seksi_id" value="{{ $seksi_id ?? '' }}">
                            <input type="text" name="koordinator_id" value="{{ $koordinator_id ?? '' }}">
                            <input type="text" name="tim_id" value="{{ $tim_id ?? '' }}">
                            <input type="text" name="status" value="{{ $status ?? '' }}">
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
    <script>
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                document.getElementById("id").value = id;
            });

            $('#modalDetailPengajuan').on('show.bs.modal', function(e) {
                var lampiran = $(e.relatedTarget).data('lampiran');
                var nama = $(e.relatedTarget).data('nama');
                var jenis_cuti = $(e.relatedTarget).data('jenis_cuti');
                var koordinator = $(e.relatedTarget).data('koordinator');
                var periode = $(e.relatedTarget).data('periode');
                var tim = $(e.relatedTarget).data('tim');
                var catatan = $(e.relatedTarget).data('catatan');
                var status = $(e.relatedTarget).data('status');

                document.getElementById("photoLampiran").src = lampiran;
                document.getElementById("nama").value = nama;
                document.getElementById("jenis_cuti").value = jenis_cuti;
                document.getElementById("koordinator").value = koordinator;
                document.getElementById("periode").value = periode;
                document.getElementById("tim").value = tim;
                document.getElementById("catatan").value = catatan;
                document.getElementById("status").innerHTML = status;
            });

            $('#modalDownloadPDF').on('show.bs.modal', function(e) {
                var href = $(e.relatedTarget).data('href');
                console.log(href);
                document.getElementById("downloadPDF").href = href;
            });
        });
    </script>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Cuti | Data Pengajuan Cuti / Izin
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Cuti</li>
            <li class="breadcrumb-item active">Pengajuan Cuti</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card h-250">
                <div class="card-header">
                    <div class="card-title">Daftar Proses Pengajuan</div>
                </div>
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar-2">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            @if ($approval_cuti->count() > 0)
                                <a href="javascript:;" class="btn btn-primary">Setujui Semua</a>
                            @endif
                        </div>
                    </div>

                    {{-- YG ISI DATABASE TA COMMENT DLU --}}
                    {{-- <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jenis Pengajuan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approval_cuti as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center">
                                                    {{ $item->jenis_cuti }} hari
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:;" class="btn btn-outline-primary" title="Terima"
                                                        data-toggle="modal" data-target="#approveModal"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline-secondary"
                                                        title="Tolak" data-toggle="modal" data-target="#rejectModal"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline-primary"
                                                        title="Lihat detail" data-toggle="modal" data-target="modalLampiran">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($approval_cuti->count() == 0)
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    Tidak ada data.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}



                    {{-- DISPLAY ONLY DELETE NANTI --}}
                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jenis Permohonan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">{{ auth()->user()->name }}</td>
                                            <td class="text-center">
                                                Cuti Tahunan
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:;" class="btn btn-primary" title="Terima"
                                                    data-toggle="modal" data-target="#approveModal" data-id="">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-secondary" title="Tolak"
                                                    data-toggle="modal" data-target="#rejectModal" data-id="">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-outline-primary" title="Lihat detail"
                                                    data-toggle="modal" data-target="#modalLampiran">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="modalLampiran"
        aria-hidden="true">
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
                                <input type="text" class="form-control" id="name" placeholder="Nama"
                                    value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="koordinator">Koordinator</label>
                                <input type="koordinator" class="form-control" id="email" placeholder="Email"
                                    value="Abdul Kahar" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tim">Tim</label>
                                <input type="text" class="form-control" id="tim" placeholder="Nomer HP"
                                    value="Pencahayaan II (Pulau Untung Jawa)" disabled>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="seksi">Jenis Pengajuan</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Seksi"
                                    value="Cuti Tahunan (2 Hari)" disabled>
                            </div>
                            <div class="form-group">
                                <label for="pulau">Periode Permohonan Cuti</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Pulau"
                                    value="21/01/2024 s/d 23/01/2024" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ciTy">Deskripsi</label>
                                <input type="koordinator" class="form-control" id="pulau" placeholder="Koordinator"
                                    value="Izin cuti mau liburan ke Maladewa" disabled>
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


    <!-- BEGIN: konfirmasi hapus modal -->
    <div id="deleteModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="mt-2 fw-bolder">Apakah anda yakin?</div>
                        <div class="text-slate-500 mt-2">
                            <p>
                                Data pengajuan ini akan dihapus secara <b>Permanen</b>!
                            </p>
                        </div>
                        <form id="deleteForm" action="{{ route('cuti.destroy') }}" method="POST" hidden>
                            @csrf
                            @method('delete')
                            <input type="text" name="id" id="id">
                        </form>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <button type="submit" form="deleteForm" class="btn btn-primary w-24 mr-1 me-2">Hapus</button>
                        <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:  konfirmasi hapus Modal -->

    <!-- BEGIN: konfirmasi approve modal -->
    <div id="approveModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="mt-2 fw-bolder">Apakah anda yakin?</div>
                        <div class="text-slate-500 mt-2">
                            <p>
                                Status pengajuan izin ini akan diubah jadi <b>"Diterima"</b>!
                            </p>
                        </div>
                        <form id="approveForm" action="{{ route('cuti.approve') }}" method="POST" hidden>
                            @csrf
                            @method('put')
                            <input type="text" name="id" id="approve_id">
                        </form>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <button type="submit" form="approveForm" class="btn btn-primary w-24 mr-1 me-2">Submit</button>
                        <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:  konfirmasi approve Modal -->

    <!-- BEGIN: konfirmasi reject modal -->
    <div id="rejectModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="mt-2 fw-bolder">Apakah anda yakin?</div>
                        <div class="text-slate-500 mt-2">
                            <p>
                                Status pengajuan izin ini akan diubah jadi <b>"Ditolak"</b>!
                            </p>
                        </div>
                        <form id="rejectForm" action="{{ route('cuti.reject') }}" method="POST" hidden>
                            @csrf
                            @method('put')
                            <input type="text" name="id" id="reject_id">
                        </form>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <button type="submit" form="rejectForm" class="btn btn-primary w-24 mr-1 me-2">Submit</button>
                        <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END:  konfirmasi reject Modal -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                document.getElementById("id").value = id;
            });

            $('#modalLampiran').on('show.bs.modal', function(e) {
                var lampiran = $(e.relatedTarget).data('lampiran');
                document.getElementById("photoLampiran").src = lampiran;
            });

            $('#approveModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                document.getElementById("approve_id").value = id;
            });

            $('#rejectModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                document.getElementById("reject_id").value = id;
            });
        });
    </script>
@endsection

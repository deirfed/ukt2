@extends('layout.base_user')

@section('title-head')
    <title>
        Cuti | Daftar Pengajuan Cuti
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.kasi.index') }}">Persetujuan Cuti</a></li>
            <li class="breadcrumb-item active">Daftar Pengajuan Seksi {{ auth()->user()->struktur->seksi->name }}</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex justify-content-center mb-3 text-center" style="text-decoration: underline">Daftar
                        Persetujuan Pengajuan Cuti - Seksi {{ auth()->user()->struktur->seksi->name }}</h4>
                    <h5 class="d-flex justify-content-center mb-3 text-center">Nomor
                        Surat dapat diakses&nbsp;<a href="https://s.id/cutipjlp" target="_blank"
                            style="text-decoration: underline; color:#034ea2">Disini</a></h5>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <div class="d-flex justify-content-start align-items-center flex-wrap">
                                <a href="{{ route('simoja.kasi.index') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                            </div>
                        </div>
                        {{-- <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <form class="form-inline mb-2 d-flex justify-content-end">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div> --}}
                    </div>
                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
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

    {{-- START: Modal Detail --}}
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END Modal Detail --}}

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
                        <form id="approveForm" class="form mt-5" action="{{ route('simoja.kasi.cuti.approve') }}"
                            method="POST">
                            @csrf
                            @method('put')
                            <input type="text" name="id" id="approve_id" hidden>
                            <div class="form-group">
                                <label for="jenis_pengajuan">Masukan Nomor Surat</label>
                                <input type="text" class="form-control" name="no_surat"
                                    placeholder="input nomor surat" required>
                            </div>
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
                        <form id="rejectForm" action="{{ route('simoja.kasi.cuti.reject') }}" method="POST" hidden>
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

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

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

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

                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center text-wrap">Nama</th>
                                            <th class="text-center text-wrap">Jabatan</th>
                                            <th class="text-center text-wrap">Tanggal Pengajuan</th>
                                            <th class="text-center text-wrap">Jumlah Hari</th>
                                            <th class="text-center text-wrap">Jenis Pengajuan</th>
                                            <th class="text-center text-wrap">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($approval_cuti as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->user->name }}</td>
                                                <td class="text-center">{{ $item->user->jabatan->name }}</td>
                                                <td class="text-center text-wrap">
                                                    {{ $item->tanggal_awal }} s/d {{ $item->tanggal_akhir }}
                                                </td>
                                                <td class="text-center">{{ $item->jumlah }} hari</td>
                                                <td class="text-center">{{ $item->jenis_cuti->name }}</td>
                                                <td class="text-center">
                                                    <a href="javascript:;" class="btn btn-outline-primary" title="Terima"
                                                        data-toggle="modal" data-target="#approveModal"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="javascript:;" class="btn btn-outline-secondary" title="Tolak"
                                                        data-toggle="modal" data-target="#rejectModal"
                                                        data-id="{{ $item->id }}">
                                                        <i class="fa fa-times"></i>
                                                    </a>
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
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($approval_cuti->count() == 0)
                                            <tr>
                                                <td class="text-center" colspan="7">
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

    <div class="modal fade" id="modalDetailPengajuan" tabindex="-1" role="dialog" aria-labelledby="modalDetailPengajuan"
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
                        <form id="approveForm" class="form mt-5" action="{{ route('cuti.approve') }}" method="POST">
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

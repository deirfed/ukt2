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
            <li class="breadcrumb-item active">Data Cuti Saya</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-7 col-md-12 col-sm-12 col-12">
            <div class="card h-250">
                <div class="card-header">
                    <div class="card-title">Pengajuan Cuti / Izin Saya</div>
                </div>
                <div class="card-body">
                    <div class="row gutters justify-content-between">
                        <div class="col-xl-1 col-lg-2 col-md-3 col-sm-6 col-12 mb-2 ml-2">
                            <a href="{{ route('cuti.create') }}" class="btn btn-primary btn-block">Ajukan Cuti</a>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12 mb-2 ml-2">
                            <span class="btn btn-outline-primary">Notes: Sisa Cuti <strong>12 Hari</strong></span>
                        </div>
                    </div>

                    <div class="projectLog">
                        <div class="logs-container">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center text-wrap">Jenis Pengajuan</th>
                                            <th class="text-center text-wrap">Status</th>
                                            <th class="text-center text-wrap">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($cuti as $item) --}}
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td class="text-center">Cuti Tahunan</td>
                                            <td class="text-center">
                                                <span class="btn btn-warning">
                                                    Diproses
                                                </span>
                                            </td>
                                            <td class="text-center my-2">
                                                <a href="javascript:;" class="btn btn-outline-primary" title="Print">
                                                    <i class="fa fa-print"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-outline-primary"
                                                    title="Lihat lampiran" data-toggle="modal"
                                                    data-target="#modalDetailPengajuan" data-lampiran="#">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-outline-secondary" title="Hapus"
                                                    data-toggle="modal" data-target="#deleteModal" data-id="#">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        {{-- @endforeach --}}
                                        {{-- @if ($cuti->count() == 0) --}}
                                        {{-- <tr>
                                                <td class="text-center" colspan="9">
                                                    Tidak ada data.
                                                </td>
                                            </tr> --}}
                                        {{-- @endif --}}
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
                                <input type="text" class="form-control" id="name" placeholder="Nama"
                                    value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="koordinator">Koordinator</label>
                                <input type="text" class="form-control" id="koordinator" placeholder="Koordinator"
                                    value="Abdul Kahar" disabled>
                            </div>
                            <div class="form-group">
                                <label for="tim">Tim</label>
                                <input type="text" class="form-control" id="tim" placeholder="Tim"
                                    value="Pencahayaan II (Pulau Untung Jawa)" disabled>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="seksi">Jenis Pengajuan</label>
                                <input type="text" class="form-control" id="seksi" placeholder="Seksi"
                                    value="Cuti Tahunan (2 Hari)" disabled>
                            </div>
                            <div class="form-group">
                                <label for="periode">Periode Permohonan Cuti</label>
                                <input type="text" class="form-control" id="periode" placeholder="periode"
                                    value="21/01/2024 s/d 23/01/2024" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ciTy">Deskripsi</label>
                                <input type="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi"
                                    value="Izin cuti mau liburan ke Maladewa" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row-modal-user gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h5>*Pengajuan Cuti masih Dalam Proses persetujuan</h5>
                            <h5>*Pengajuan Cuti Sudah <span style="color: green">Disetujui</span> pada Tanggal 29/01/2024
                            </h5>
                            <h5>*Pengajuan Cuti <span style="color: red">Ditolak</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

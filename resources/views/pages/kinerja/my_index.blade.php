@extends('layout.base')

@section('title-head')
    <title>
        Kinerja | Laporan Kinerja Saya
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Kinerja</li>
            <li class="breadcrumb-item active">Daftar Laporan Kinerja Saya</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    </div>
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="btn-group">
                                <a class="btn btn-primary mb-3" href="{{ route('kinerja.create') }}">
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <form class="form-inline mb-2">
                            <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                aria-label="Search" id="search-bar">
                            <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                        </form>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Seksi</th>
                                        <th class="text-center">Tim</th>
                                        <th class="text-center">Pulau</th>
                                        <th class="text-center">Koordinator</th>
                                        <th class="text-center">PJLP</th>
                                        <th class="text-center">Giat/Pekerjaan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">{{ auth()->user()->name }}</td>
                                        <td class="text-center">Pencahayaan</td>
                                        <td class="text-center">Tim Pencahayaan I</td>
                                        <td class="text-center">Untung Jawa</td>
                                        <td class="text-center">Abduk Kohar Mudzakir</td>
                                        <td class="text-center">Bambang</td>
                                        <td class="text-center">Perbaikan lampu depan masjid al-ikhlas</td>
                                        <td class="text-center">
                                            <button class="btn btn-outline-primary" data-toggle="modal"
                                                data-target=".detailKinerja"><i class="fa fa-eye"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">{{ auth()->user()->name }}</td>
                                        <td class="text-center">Pertamanan</td>
                                        <td class="text-center">Tim Pertamanan I</td>
                                        <td class="text-center">Tidung</td>
                                        <td class="text-center">Ridwan Faldi Rakabuming</td>
                                        <td class="text-center">Kurmen</td>
                                        <td class="text-center">Perbaikan drainase mampet depan masjid al-amin</td>
                                        <td class="text-center">
                                            <button class="btn btn-outline-primary" data-toggle="modal"
                                                data-target=".detailKinerja"><i class="fa fa-eye"></i></button>
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

    {{-- BEGIN: Modal Detail --}}
    <div class="modal fade detailKinerja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Detail Kinerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row gutters">
                        <div
                            class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 modal-image mb-5 d-flex justify-content-center">
                            <img src="{{ asset('assets/img/background-page.jpg') }}" class="img-fluid"
                                style="border-radius: 20px" alt="Ombak Admin">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="nama">Unit Kerja</label>
                                <input type="text" class="form-control" id="name" placeholder="Nama" value="UKT 2"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="eMail">Tim</label>
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                    value='Tim Pencahayaan I' disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone">Pulau</label>
                                <input type="text" class="form-control" id="no_hp" placeholder="Nomer HP"
                                    value="Untung Jawa" disabled>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="seksi">Seksi</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Seksi"
                                    value="Pencahayaan" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ciTy">Koordinator</label>
                                <input type="koordinator" class="form-control" id="pulau" placeholder="Koordinator"
                                    value="Abdul Kohar Mudzakhir" disabled>
                            </div>
                            <div class="form-group">
                                <label for="pulau">Giat/Pekerjaan</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Pulau"
                                    value="Pekerjaan perbaikan drainase depan masjid al-ikhlas" disabled>
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
    {{-- END: Modal Detail --}}

    {{-- BEGIN: Filter Modal --}}
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
                    <div class="form-row gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="">Pulau</label>
                                <select name="pulau" class="form-control" required>
                                    <option value="" selected disabled>- pilih pulau -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Seksi</label>
                                <select name="seksi" class="form-control" required>
                                    <option value="" selected disabled>- pilih seksi -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="koordinator">Koordinator</label>
                                <select name="koordinator" class="form-control" required>
                                    <option value="" selected disabled>- pilih koordinator -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="koordinator">Tim</label>
                                <select name="koordinator" class="form-control" required>
                                    <option value="" selected disabled>- pilih tim -</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status Cuti</label>
                                <select name="status" class="form-control" required>
                                    <option value="" selected disabled>- pilih status -</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label for="periode">Periode</label>
                    <div class="form-row gutters">
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <input type="date" class="form-control" id="start" placeholder="start">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <input type="date" class="form-control" id="end" placeholder="end">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Filter Data</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Filter Modal --}}
@endsection


@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }
    </script>
@endsection

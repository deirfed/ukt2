@extends('layout.base')

@section('title-head')
    <title>
        Absensi | Data Absensi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Absensi</li>
            <li class="breadcrumb-item active">Data Absensi Lapangan</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Absensi Lapangan</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            {{-- @if ($absensi->count() > 0) --}}
                            <button class="btn btn-primary">Export to Excel</i></button>
                            <button class="btn btn-primary">Export to PDF</button>
                            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modalFilter"><i
                                    class="fa fa-filter"></i></a>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tipe Absensi</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Status Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                    <th class="text-center">Status Pulang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->user->name }}</td>
                                        <td class="text-center">{{ $item->jenis_absensi->name }}</td>
                                        <td class="text-center">{{ $item->tanggal }}</td>
                                        <td class="text-center">{{ $item->jam_masuk }}</td>
                                        <td class="text-center">{{ $item->status_masuk }}</td>
                                        <td class="text-center">{{ $item->jam_pulang }}</td>
                                        <td class="text-center">{{ $item->status_pulang }}</td>
                                        <td class="text-center">
                                            <span class="btn btn-primary">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('absensi.edit', $item->uuid) }}"><button
                                                    class="btn btn-outline-primary"><i class="fa fa-edit"></i></button></a>
                                            <a href="#" href="javascript:;" data-toggle="modal"
                                                data-target="#delete-confirmation-modal"
                                                onclick="toggleModal('{{ $item->id }}')"><button
                                                    class="btn btn-outline-danger"><i class="fa fa-trash"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="text-3xl mt-2">Apakah anda yakin?</div>
                        <div class="text-slate-500 mt-2">Peringatan: Data ini akan dihapus secara permanent</div>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <form action="{{ route('absensi.destroy') }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="text" name="id" id="id" hidden>
                            <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Batal</button>
                            <button type="submit" class="btn btn-primary w-24">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->

    {{-- BEGIN: Filter Modal --}}
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

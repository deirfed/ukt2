@extends('layout.base_user')

@section('title-head')
    <title>
        Kinerja | Daftar Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.pjlp.index') }}">Kinerja PJLP</a></li>
            <li class="breadcrumb-item active">Daftar Kinerja Saya</li>
    </div>
@endsection


@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex justify-content-center mb-3 text-center" style="text-decoration: underline">Kinerja Saya
                    </h4>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <div class="d-flex justify-content-start align-items-center flex-wrap">
                                <a href="{{ route('simoja.pjlp.index') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                                <a href="{{ route('simoja.pjlp.kinerja-create') }}"
                                    class="btn btn-primary mr-2 mb-2 mb-sm-0">Tambah
                                    Data</a>
                                <a href="" class="btn btn-primary mb-2 mb-sm-0" data-toggle="modal"
                                    data-target="#modalFilter"><i class="fa fa-filter"></i></a>
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Pulau</th>
                                    <th class="text-center">Koordinator</th>
                                    <th class="text-center">Tim</th>
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
                                        <td class="text-center">{{ $item->tanggal }}</td>
                                        <td class="text-center">{{ $item->anggota->name ?? '-' }}</td>
                                        <td class="text-center">Pulau {{ $item->formasi_tim->area->pulau->name }}</td>
                                        <td class="text-center">{{ $item->koordinator->name ?? '-' }}</td>
                                        <td class="text-center">{{ $item->formasi_tim->struktur->tim->name }}</td>
                                        <td class="text-center">{{ $item->kategori->name ?? $item->kegiatan }}</td>
                                        <td class="text-center">{{ $item->deskripsi ?? '-' }}</td>
                                        <td class="text-center">{{ $item->lokasi ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="#" data-toggle="modal" data-target="#modalDokumentasi"
                                                data-photo='{{ $item->photo }}'><button class="btn btn-outline-primary"><i
                                                        class="fa fa-eye"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($kinerja->count() == 0)
                                    <tr>
                                        <td class="text-center" colspan="10">
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
    {{-- END: FILTER KINERJA --}}

    {{-- START: MODAL DOKUMENTASI --}}
    <div class="modal fade" id="modalDokumentasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAdminTitle">Dokumentasi Kinerja</h4>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="mb-4 text-center align-middle">
                            <div class="border mx-auto" style="width: 70%">
                                <p class="fw-bolder mb-0">Dokumentasi Kegiatan</p>
                                <div id="photo_modal" class="container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END: MODAL DOKUMENTASI --}}
@endsection


@section('javascript')
    <script type="text/javascript">
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

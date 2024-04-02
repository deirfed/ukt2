@extends('layout.base_user')

@section('title-head')
    <title>
        Pengiriman | Detail Pengiriman Barang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Pengiriman</li>
            <li class="breadcrumb-item active">Data Detail Pengiriman Barang</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="d-flex justify-content-center mb-3 text-center" style="text-decoration: underline">Detail Data
                        Pengiriman Barang</h4>
                    <div class="row d-flex justify-content-between align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <div class="d-flex justify-content-start align-items-center flex-wrap">
                                <a href="{{ route('aset.pengiriman.index') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 mb-sm-0"><i class="fa fa-arrow-left"></i>
                                    Kembali</a>
                                @if ($validasiBAST == 0)
                                    <a href="javascript:;" class="btn btn-primary" data-toggle="modal"
                                        data-target="#bast-confirmation-modal" title="Buat BAST Penerimaan Barang">
                                        <i class="fa fa-print"></i> Generate BAST Penerimaan Barang
                                    </a>
                                @endif
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
                        <p>NOTE: Generate BAST hanya bisa dilakukan ketika data dokumentasi & penerimaan lengkap.</p>
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Qty.</th>
                                    <th class="text-center">Asal</th>
                                    <th class="text-center">Tujuan</th>
                                    <th class="text-center">Pengirim</th>
                                    <th class="text-center">Tanggal Kirim</th>
                                    <th class="text-center">Photo Kirim</th>
                                    <th class="text-center">Penerima</th>
                                    <th class="text-center">Tanggal Terima</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="formTerima" action="{{ route('pengiriman.barang.terima') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($pengiriman_barang as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->barang->name }}</td>
                                            <td class="text-center">{{ $item->qty }} {{ $item->barang->satuan }}</td>
                                            <td class="text-center">Gudang Utama</td>
                                            <td class="text-center">{{ $item->gudang->name }}</td>
                                            <td class="text-center text-wrap">{{ $item->submitter->name }}</td>
                                            <td class="text-center">
                                                {{ $item->tanggal_kirim ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('storage/' . $item->photo_kirim) }}" style="height: 70px"
                                                    alt="photo_kirim">
                                            </td>
                                            <td class="text-center text-wrap">{{ $item->receiver->name ?? '-' }}</td>
                                            <td class="text-center">
                                                {{ $item->tanggal_terima ?? '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->status }}
                                            </td>
                                            <td class="text-center">
                                                {{-- <a href="javascript:;"
                                                    data-url="{{ route('pengiriman.barang.photo.terima', $item->id) }}"
                                                    data-toggle="modal" data-target="#modalPhotoTerima"
                                                    class="btn btn-outline-primary" title="Upload Photo"><i
                                                        class="fa fa-edit"></i>
                                                </a> --}}
                                                {{-- @if ($item->photo_terima != null) --}}
                                                    <a href="javascript:;" class="btn btn-outline-primary"
                                                        title="Lihat Photo" data-toggle="modal" data-target="#modalLampiran"
                                                        data-photo="
                                                        {{-- {{ $item->photo_terima }} --}}
                                                        "><i class="fa fa-eye"></i>
                                                    </a>
                                                {{-- @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-right">
                        <button style="display: none;" id="konfirmasiPenerimaanButton" class="btn btn-primary"
                            data-toggle="modal" data-target="#konfirmasiPenerimaanBarangModal"
                            title="Konfirmasi Penerimaan Barang">
                            <i class="fas fa-check"></i>
                            Konfirmasi Penerimaan Barang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BEGIN: BAST Modal Confirmation --}}
    <div id="bast-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <h4 class="text-3xl mt-2">Apakah anda yakin?</h4>
                        <div class="text-slate-500 mt-2">BAST akan dibuat berdasarkan data yang ditampilkan!</div>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <form action="{{ route('pengiriman.barang.generate.BAST') }}" method="GET">
                            @csrf
                            @method('GET')
                            <input type="text" name="no_resi" value="{{ $nomor_resi }}" id="no_resi" hidden>
                            <button type="button" data-dismiss="modal"
                                class="btn btn-dark w-24 mr-1 me-2">Batal</button>
                            <button type="submit" class="btn btn-primary w-24">Buat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: BAST Moal --}}

    {{-- BEGIN: Konfirmasi Penerimaan Barang --}}
    <div id="konfirmasiPenerimaanBarangModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <h4 class="text-3xl mt-2">Apakah anda yakin?</h4>
                        <div class="text-slate-500 mt-2">Semua barang yang dipilih, akan dikonfirmasi telah diterima di
                            gudang pulau tujuan.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Batal</button>
                    <button type="submit" form="formTerima" class="btn btn-primary w-24">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi Penerimaan Barang --}}

    {{-- BEGIN: Lampiran Modal --}}
    <div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="modalLampiran"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dokumentasi Bukti Penerimaan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div class="row gutters">
                        <div id="photo_modal" class="container">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Lampiran Modal --}}

    {{-- BEGIN: Photo Terima Modal --}}
    <div class="modal fade" id="modalPhotoTerima" tabindex="-1" role="dialog" aria-labelledby="modalPhotoTerima"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Photo Barang Bukti Terima</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <form id="formPhotoTerima" action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Photo Barang <span class="text-secondary">(*max: 3
                                    photo)</span></label>
                            <div class="row-group d-flex preview-container my-2">
                            </div>
                            <input type="file" class="form-control image-input" name="photo[]" accept="image/*"
                                required multiple>
                        </div>
                        @error('photo')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="formPhotoTerima" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Photo Terima Modal --}}
@endsection

@section('javascript')
    <script>
        const imageInputs = document.querySelectorAll('.image-input');
        const previewContainer = document.querySelector('.preview-container');

        imageInputs.forEach(input => {
            input.addEventListener('change', function(event) {
                previewContainer.innerHTML = '';

                const files = event.target.files;
                for (const file of files) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewImage = document.createElement('img');
                        previewImage.className = 'preview-image';
                        previewImage.src = e.target.result;
                        previewImage.style = 'height: 150px;';
                        previewImage.className = 'img-thumbnail btn-group mt-2 me-2 d-inline-flex';

                        previewContainer.appendChild(previewImage);
                    }

                    reader.readAsDataURL(file);
                }
            });
        });

        // $('#modalLampiran').on('show.bs.modal', function(e) {
        //     var photoArray = $(e.relatedTarget).data('photo');
        //     var photoHTML = '';

        //     photoArray.forEach(function(item) {
        //         var photoPath = "{{ asset('storage/') }}" + '/' + item;
        //         photoHTML +=
        //             '<div class""><img class="img-thumbnail img-fluid" style="width: 400px;" src="' +
        //             photoPath + '" alt="photo"></div>';
        //     });

        //     document.getElementById("photo_modal").innerHTML = photoHTML;
        // });

        // $('#modalPhotoTerima').on('show.bs.modal', function(e) {
        //     var url = $(e.relatedTarget).data('url');

        //     document.getElementById("formPhotoTerima").action = url;
        // });


        $('input[type="checkbox"]').change(function() {
            var diceklis = $('input[type="checkbox"]:checked').length > 0;

            if (diceklis) {
                $('#konfirmasiPenerimaanButton').show();
            } else {
                $('#konfirmasiPenerimaanButton').hide();
            }
        });
    </script>
@endsection

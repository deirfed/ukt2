@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Detail Pengiriman Barang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item active">Data Detail Pengiriman Barang</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <br>
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="{{ route('pengiriman.index') }}" class="btn btn-outline-primary">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                            <a href="" class="btn btn-primary" data-toggle="modal"
                                data-target="#bast-confirmation-modal" title="Buat BAST Pengiriman">
                                <i class="fa fa-print"></i> Generate BAST Penerimaan Barang
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
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
                                    <th class="text-center">Photo Terima</th>
                                    <th class="text-center">Status</th>
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
                                                <input type="text" name="ids[]" value="{{ $item->id }}" hidden>
                                                @if ($item->photo_terima == '')
                                                    <div class="preview">
                                                    </div>
                                                    <input type="file" class="form-control" name="photo_terima[]"
                                                        accept="image/*" required>
                                                @else
                                                    <img src="{{ asset('storage/' . $item->photo_terima) }}"
                                                        style="height: 70px" alt="photo_terima">
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ $item->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>
                    </div>
                    @if ($validasi > 0)
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-right">
                            <button type="submit" form="formTerima" class="btn btn-primary">
                                <i class="fas fa-check"></i>
                                Konfirmasi Penerimaan Barang
                            </button>
                        </div>
                    @endif
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
                        <div class="text-3xl mt-2">Apakah anda yakin?</div>
                        <div class="text-slate-500 mt-2">BAST akan dibuat berdasarkan data yang ditampilkan!</div>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <form action="#" method="POST">
                            @csrf
                            @method('delete')
                            <input type="text" name="id" id="id" hidden>
                            <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Batal</button>
                            <button type="submit" class="btn btn-primary w-24">Buat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END: BAST Moal --}}
@endsection

@section('javascript')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInputs = document.querySelectorAll('input[type="file"]');

            fileInputs.forEach(function(input) {
                input.addEventListener("change", function(event) {
                    const file = event.target.files[0];
                    const preview = event.target.closest("td").querySelector(".preview");

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function() {
                            const img = document.createElement("img");
                            img.src = reader.result;
                            img.classList.add("img-thumbnail");
                            img.classList.add("my-1");
                            img.style.height = "100px";
                            preview.innerHTML = "";
                            preview.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    } else {
                        preview.innerHTML = "";
                    }
                });
            });
        });
    </script>
@endsection

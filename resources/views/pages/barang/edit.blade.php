@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Edit Data Barang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item">Data Pengadaan</li>
            <li class="breadcrumb-item active">Tambah Data Pengadaan</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
            <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Edit Data Barang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="no_kontrak">Kontrak Pengadaan</label>
                                    <input type="text" hidden value="{{ $barang->id }}" name="id">
                                    <input type="text" class="form-control" id="start"
                                        value="{{ $barang->kontrak->name }} ({{ $barang->kontrak->periode }})" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Nama Barang</label>
                                    <input type="text" name="name" class="form-control" value="{{ $barang->name }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="jenis">Jenis Barang</label>
                                    <select class="form-control" name="jenis" required>
                                        <option value="">- pilih jenis barang-</option>
                                        <option value="consumable"
                                            {{ strcasecmp($barang->jenis, 'consumable') === 0 ? 'selected' : '' }}>
                                            Consumable</option>
                                        <option value="tools"
                                            {{ strcasecmp($barang->jenis, 'tools') === 0 ? 'selected' : '' }}>Tools</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="code">Kode Barang</label>
                                    <input type="text" class="form-control" name="code" value="{{ $barang->code }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="merk">Merk Barang</label>
                                    <input type="text" class="form-control" name="merk" value="{{ $barang->merk }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Stock Awal</label>
                                    <input type="text" class="form-control" name="stock_awal"
                                        value="{{ $barang->stock_awal }}">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Stock Aktual</label>
                                    <input type="text" class="form-control" name="stock_aktual"
                                        value="{{ $barang->stock_aktual }}">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Satuan Barang</label>
                                    <input type="text" class="form-control" name="satuan"
                                        value="{{ $barang->satuan }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Harga Barang</label>
                                    <input type="text" class="form-control" name="harga" value="{{ $barang->harga }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Spesifikasi</label>
                                    <input type="text" class="form-control" name="spesifikasi"
                                        value="{{ $barang->spesifikasi }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Photo Barang</label>
                                    <div class="container my-2">
                                        <img class="img-thumbnail" id="previewImage" style="height: 200px"
                                            src="{{ $barang->photo != null ? asset('storage/' . $barang->photo) : 'https://media.istockphoto.com/id/1000398280/vector/photo-not-available-icon-isolated-on-white-background.jpg?s=170667a&w=0&k=20&c=O-C_gKquacdLvHl-jDHN80Cy9_LqbI0Fqj7foLIm6wo=' }}"
                                            alt="Photo Barang">
                                    </div>
                                    <input type="file" class="form-control" id="imageInput" name="photo"
                                        accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                }

                reader.readAsDataURL(selectedFile);
            }
        });
    </script>
@endsection

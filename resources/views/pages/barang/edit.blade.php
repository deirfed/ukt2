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
            <form action="{{ route('barang.update', $barang->id) }}" method="POST">
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
                                    <select class="form-control" name="jenis">
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
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="name">Stock Awal</label>
                                    <input type="text" class="form-control" name="stock_awal"
                                        value="{{ $barang->stock_awal }}">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
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

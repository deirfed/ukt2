@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Tambah Data Pengadaan
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
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Pengadaan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">No. Kontrak</label>
                            <select name="no_kontrak" class="form-control" required>
                                <option value="" selected disabled>- pilih no kontrak -</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Kontrak</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Masukkan Nama Kontrak" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tahun Pengadaan</label>
                            <input type="text" class="form-control" id="tahun" name="tahun"
                                placeholder="Masukkan Tahun Pengadaan" required>
                        </div>
                        <div class="form-group">
                            <label for="">Import Dokumen Kontrak (PDF - Optional)</label>
                            <input type="file" class="form-control" id="importdata" name="importdata"
                                placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="">Import List Data Pengadaan (Excel)</label>
                            <input type="file" class="form-control" id="importdata" name="importdata"
                                placeholder="" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('pengadaan.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

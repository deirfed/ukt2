@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Jabatan
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Jabatan</li>
            <li class="breadcrumb-item active">Ubah Data Jabatan</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Jabatan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Jabatan</label>
                            <input type="text" hidden value="{{ $jabatan->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $jabatan->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Jabatan</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $jabatan->code }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('jabatan.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

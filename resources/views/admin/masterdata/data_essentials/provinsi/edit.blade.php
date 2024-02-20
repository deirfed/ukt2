@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Provinsi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Provinsi</li>
            <li class="breadcrumb-item active">Ubah Data Provinsi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('provinsi.update', $provinsi->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Provinsi</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Provinsi</label>
                            <input type="text" hidden value="{{ $provinsi->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $provinsi->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Provinsi</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $provinsi->code }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('provinsi.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

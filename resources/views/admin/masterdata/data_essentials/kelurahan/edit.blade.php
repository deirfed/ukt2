@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Kelurahan
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Kelurahan</li>
            <li class="breadcrumb-item active">Ubah Data Kelurahan</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kelurahan.update', $kelurahan->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Kelurahan</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Kelurahan</label>
                            <input type="text" hidden value="{{ $kelurahan->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $kelurahan->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Kelurahan</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $kelurahan->code }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('kelurahan.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

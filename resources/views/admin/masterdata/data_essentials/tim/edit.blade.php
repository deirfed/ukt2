@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Tim
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Tim</li>
            <li class="breadcrumb-item active">Ubah Data Tim</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('tim.update', $tim->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Tim</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Tim</label>
                            <input type="text" hidden value="{{ $tim->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $tim->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Tim</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $tim->code }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('tim.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

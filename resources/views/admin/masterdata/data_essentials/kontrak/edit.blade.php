@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Kontrak
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Kontrak</li>
            <li class="breadcrumb-item active">Ubah Data No. Kontrak</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kontrak.update', $kontrak->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data No. Kontrak</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Kontrak</label>
                            <input type="text" hidden value="{{ $kontrak->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $kontrak->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Nomor Kontrak</label>
                            <input type="text" class="form-control" name="no_kontrak" autocomplete="off"
                                value="{{ $kontrak->no_kontrak }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tahun Pengadaan</label>
                            <input type="text" class="form-control" name="periode" autocomplete="off"
                                value="{{ $kontrak->tahun }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('kontrak.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

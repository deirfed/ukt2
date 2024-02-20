@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Ubah Data Seksi
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Seksi</li>
            <li class="breadcrumb-item active">Ubah Data Seksi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('seksi.update', $seksi->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Edit Seksi</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Seksi</label>
                            <input type="text" hidden value="{{ $seksi->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $seksi->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Seksi</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $seksi->code }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('seksi.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

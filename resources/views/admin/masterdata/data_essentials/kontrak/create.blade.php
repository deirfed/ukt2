@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Kontrak
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Kontrak</li>
            <li class="breadcrumb-item active">Tambah Data No. Kontrak</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kontrak.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Kontrak</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="no_kontrak" name="no_kontrak"
                                placeholder="No. Kontrak" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Kontrak" required>
                        </div>
                        <select name="periode" class="form-control" required>
                            <option value="" selected disabled>- pilih periode pengadaan-</option>
                            <option value="{{ $this_year }}">{{ $this_year }}</option>
                            <option value="{{ $this_year + 1 }}">{{ $this_year + 1 }}</option>
                        </select>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('kontrak.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Data Laporan Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Kinerja</li>
            <li class="breadcrumb-item active">Input Laporan Kinerja</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kinerja.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Laporan Kerja</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="Joko Susilo" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Pulau & Team</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="Untung Jawa (Pencahayaan I)" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Koordinator</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="Ahamd Subekti" disabled>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('kinerja.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

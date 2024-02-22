@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Data Relasi Struktur
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Struktur</li>
            <li class="breadcrumb-item active">Tambah Data Relasi Struktur</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('struktur.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Struktur</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Unit Kerja</label>
                            <select name="unitkerja_id" class="form-control" required>
                                <option value="" selected disabled>- pilih unit kerja -</option>
                                @foreach ($unitkerja as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Seksi</label>
                            <select name="seksi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih seksi -</option>
                                @foreach ($seksi as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tim</label>
                            <select name="tim_id" class="form-control" required>
                                <option value="" selected disabled>- pilih tim -</option>
                                @foreach ($tim as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('struktur.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

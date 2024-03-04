@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Data Relasi Konfigurasi Gudang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Konfigurasi Gudang</li>
            <li class="breadcrumb-item active">Tambah Data Relasi Konfigurasi Gudang</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('konfigurasi_gudang.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Konfigurasi Gudang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <select name="periode" class="form-control" required>
                                <option value="" selected disabled>- pilih periode -</option>
                                <option value="{{ $this_year }}">{{ $this_year }}</option>
                                <option value="{{ $this_year + 1 }}">{{ $this_year + 1 }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Gudang</label>
                            <select name="gudang_id" class="form-control" required>
                                <option value="" selected disabled>- pilih gudang -</option>
                                @foreach ($gudang as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Pulau</label>
                            <select name="pulau_id" class="form-control" required>
                                <option value="" selected disabled>- pilih pulau -</option>
                                @foreach ($pulau as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Seksi</label>
                            <select name="seksi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih seksi -</option>
                                @foreach ($seksi as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('konfigurasi_gudang.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

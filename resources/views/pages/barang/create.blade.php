@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Tambah Data Barang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item">Data Barang</li>
            <li class="breadcrumb-item active">Tambah Data Barang</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <form action="" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Barang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Masukkan Nama Kontrak</label>
                            <select name="kontrak_id" class="form-control" required>
                                <option value="" selected disabled>- pilih kontrak -</option>
                                @foreach ($kontrak as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->periode }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Import List Data Pengadaan (Excel)</label>
                            <input type="file" class="form-control" id="importdata" name="importdata"
                                placeholder="" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

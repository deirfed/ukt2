@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Relasi Konfigurasi Gudang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Konfigurasi Gudang</li>
            <li class="breadcrumb-item active">Ubah Data Relasi Konfigurasi Gudang</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('konfigurasi_gudang.update', $konfigurasi_gudang->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Konfigurasi Gudang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <input type="text" class="form-control" name="periode"
                                value="{{ $konfigurasi_gudang->periode }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="">Gudang</label>
                            <select name="gudang_id" class="form-control" required>
                                <option value="" selected disabled>- pilih gudang -</option>
                                @foreach ($gudang as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $konfigurasi_gudang->gudang->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pulau</label>
                            <select name="pulau_id" class="form-control" required>
                                <option value="" selected disabled>- pilih pulau -</option>
                                @foreach ($pulau as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $konfigurasi_gudang->pulau->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Seksi</label>
                            <select name="seksi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih seksi -</option>
                                @foreach ($seksi as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $konfigurasi_gudang->pulau->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah</button>
                            <a href="{{ route('konfigurasi_gudang.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

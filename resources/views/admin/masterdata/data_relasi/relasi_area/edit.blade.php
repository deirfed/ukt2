@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Relasi Area
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Area</li>
            <li class="breadcrumb-item active">Ubah Data Relasi Area</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('area.update', $area->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Area</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select name="provinsi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih provinsi -</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $area->provinsi->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kota / Kabupaten</label>
                            <select name="walikota_id" class="form-control" required>
                                <option value="" selected disabled>- pilih kota / kabupaten -</option>
                                @foreach ($walikota as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $area->walikota->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kecamatan</label>
                            <select name="kecamatan_id" class="form-control" required>
                                <option value="" selected disabled>- pilih kecamatan -</option>
                                @foreach ($kecamatan as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $area->kecamatan->id) selected @endif>
                                        Kecamatan {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kelurahan</label>
                            <select name="kelurahan_id" class="form-control" required>
                                <option value="" selected disabled>- pilih kelurahan -</option>
                                @foreach ($kelurahan as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $area->kelurahan->id) selected @endif>
                                        Kelurahan {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pulau</label>
                            <select name="pulau_id" class="form-control" required>
                                <option value="" selected disabled>- pilih pulau -</option>
                                @foreach ($pulau as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $area->pulau->id) selected @endif>
                                        Pulau {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah</button>
                            <a href="{{ route('area.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

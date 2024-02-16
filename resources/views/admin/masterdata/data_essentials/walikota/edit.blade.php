@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Ubah Data Walikota/Kabupaten
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Walikota/Kabupaten</li>
            <li class="breadcrumb-item active">Ubah Data Walikota/Kabupaten</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('walikota.update', $walikota->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Walikota/Kabupaten</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Walikota/Kabupaten</label>
                            <input type="text" hidden value="{{ $walikota->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $walikota->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $walikota->code }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select class="form-control selectpicker" name="provinsi_id">
                                <option disabled value="" selected> - Pilih Provinsi - </option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->id }}" @if ($walikota->provinsi_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Admin / Narahubung</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $walikota->admin_id }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('walikota.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

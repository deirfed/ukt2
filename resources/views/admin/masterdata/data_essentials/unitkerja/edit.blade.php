@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Unit Kerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Provinsi</li>
            <li class="breadcrumb-item active">Ubah Data Unit Kerja</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('unitkerja.update', $unitkerja->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Unit Kerja</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Unit Kerja</label>
                            <input type="text" hidden value="{{ $unitkerja->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $unitkerja->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Kode Unit Kerja</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $unitkerja->code }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Walikota</label>
                            <select class="form-control selectpicker" name="walikota_id">
                                <option disabled value="" selected> - Pilih Walikota - </option>
                                @foreach ($walikota as $item)
                                    <option value="{{ $item->id }}" @if ($unitkerja->provinsi_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Provinsi</label>
                            <select class="form-control selectpicker" name="provinsi_id">
                                <option disabled value="" selected> - Pilih Provinsi - </option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->id }}" @if ($unitkerja->provinsi_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Admin Provinsi</label>
                            <input type="text" class="form-control" name="admin_id" autocomplete="off"
                                value="{{ $unitkerja->admin_id }}" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Update Data</button>
                            <a href="{{ route('unitkerja.index') }}" class="btn btn-dark">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

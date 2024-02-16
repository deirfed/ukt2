@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Tambah Walikota/Kabupaten
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Walikota/Kabupaten</li>
            <li class="breadcrumb-item active">Tambah Data Walikota/Kabupaten</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('walikota.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Walikota/Kabupaten</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Walikota/Kabupaten" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Kode Walikota/Kabupaten" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="provinsi_id" required>
                                <option disabled value="" selected> - Pilih Provinsi - </option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="admin_id" name="admin_id"
                                placeholder="Admin / Narahubung" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                            class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('walikota.index') }}" class="btn btn-dark">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Kategori
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Kategori</li>
            <li class="breadcrumb-item active">Ubah Data Kategori</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kategori.update', $kategori->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Edit Role</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $kategori->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Seksi</label>
                            <select name="seksi_id" id="seksi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih seksi -</option>
                                @foreach ($seksi as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $kategori->seksi->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

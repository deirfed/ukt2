@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Kontrak
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Kontrak</li>
            <li class="breadcrumb-item active">Tambah Data No. Kontrak</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kontrak.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Kontrak</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <select name="seksi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih seksi -</option>
                                @foreach ($seksi as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="no_kontrak" name="no_kontrak"
                                placeholder="No. Kontrak" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Kontrak" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="nilai_kontrak"
                                placeholder="Nilai Kontrak (Rp.)" required>
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Tanggal Kontrak" onblur="(this.type='text')"
                                onfocus="(this.type='date')" class="form-control" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label for="">Dokumen Kontrak <span class="text-danger">(PDF Max: 1MB)</span></label>
                            <input type="file" class="form-control" name="lampiran" placeholder="Dokumen Kontrak Kontrak"
                                required accept="application/pdf" required>
                            @error('lampiran')
                                <div class="container">
                                    <p class="text-danger">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('kontrak.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

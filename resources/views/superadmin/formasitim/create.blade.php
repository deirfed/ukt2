@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Data Relasi Formasi Tim
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Formasi Tim</li>
            <li class="breadcrumb-item active">Tambah Formasi Tim</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('admin-formasi_tim.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Formasi Tim</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <select name="periode" class="form-control" required>
                                <option value="" selected disabled>- pilih periode -</option>
                                <option value="{{ $periode }}">{{ $periode }}</option>
                                <option value="{{ $periode + 1 }}">{{ $periode + 1 }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tim</label>
                            <select name="struktur_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama tim -</option>
                                @foreach ($struktur as $item)
                                    <option value="{{ $item->id }}">{{ $item->tim->name }} ({{ $item->seksi->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pulau</label>
                            <select name="area_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama pulau -</option>
                                @foreach ($area as $item)
                                    <option value="{{ $item->id }}">{{ $item->pulau->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Koordinator</label>
                            <select name="koordinator_id" class="form-control" required>
                                <option value="" selected disabled>- pilih koordinator -</option>
                                @foreach ($koordinator as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Anggota</label>
                            <select name="anggota_id" class="form-control" required>
                                <option value="" selected disabled>- pilih anggota -</option>
                                @foreach ($anggota as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('admin-formasi_tim.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

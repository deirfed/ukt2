@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Data Relasi Konfigurasi Absensi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Konfigurasi Absensi</li>
            <li class="breadcrumb-item active">Tambah Data Relasi Konfigurasi Absensi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('konfigurasi_absensi.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Konfigurasi Absensi</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Jenis Absensi</label>
                            <select name="jenis_absensi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih jenis absensi -</option>
                                @foreach ($jenis_absensi as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Masuk</label>
                            <input type="time" name="jam_masuk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Pulang</label>
                            <input type="time" name="jam_pulang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Toleransi Masuk (Menit)</label>
                            <input type="number" name="toleransi_masuk" class="form-control" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="">Toleransi Pulang (Menit)</label>
                            <input type="number" name="toleransi_pulang" class="form-control" required min="0">
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('konfigurasi_absensi.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

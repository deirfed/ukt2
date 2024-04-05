@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Relasi Konfigurasi Cuti
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Konfigurasi Absensi</li>
            <li class="breadcrumb-item active">Ubah Data Relasi Konfigurasi Absensi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('konfigurasi_absensi.update', $konfigurasi_absensi->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Konfigurasi Absensi</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Jenis Absensi</label>
                            <select name="jenis_absensi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih jenis absensi -</option>
                                @foreach ($jenis_absensi as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $konfigurasi_absensi->jenis_absensi->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Datang</label>
                            <input type="time" name="jam_masuk" value="{{ $konfigurasi_absensi->jam_masuk }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Pulang</label>
                            <input type="time" name="jam_pulang" value="{{ $konfigurasi_absensi->jam_pulang }}"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Toleransi Datang (Menit)</label>
                            <input type="number" name="toleransi_masuk" value="{{ $konfigurasi_absensi->toleransi_masuk }}"
                                class="form-control" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="">Toleransi Pulang (Menit)</label>
                            <input type="number" name="toleransi_pulang"
                                value="{{ $konfigurasi_absensi->toleransi_pulang }}" class="form-control" required
                                min="0">
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

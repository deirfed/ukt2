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
            <li class="breadcrumb-item">Konfigurasi Cuti</li>
            <li class="breadcrumb-item active">Ubah Data Relasi Konfigurasi Cuti</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('konfigurasi_cuti.update', $konfigurasi_cuti->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Formasi Tim</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <input type="text" class="form-control" name="periode"
                                value="{{ $konfigurasi_cuti->periode }}" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="">Karyawan</label>
                            <select name="user_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama karyawan -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $konfigurasi_cuti->user->id) selected @endif>
                                        {{ $item->name }}
                                        ({{ $item->employee_type->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Cuti</label>
                            <select name="jenis_cuti_id" class="form-control" required>
                                <option value="" selected disabled>- pilih jenis cuti -</option>
                                @foreach ($jenis_cuti as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $konfigurasi_cuti->jenis_cuti->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah Jatah Cuti (hari)</label>
                            <input type="number" name="jumlah" class="form-control"
                                value="{{ $konfigurasi_cuti->jumlah }}" required min="1">
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah</button>
                            <a href="{{ route('konfigurasi_cuti.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

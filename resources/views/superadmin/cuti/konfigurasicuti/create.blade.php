@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Masterdata | Tambah Data Relasi Konfigurasi Cuti
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Cuti</li>
            <li class="breadcrumb-item active">Tambah Konfigurasi Cuti</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('admin-konfigurasi_cuti.store') }}" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Tambah Data Konfigurasi Cuti</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <select name="periode" class="form-control" required>
                                <option value="" selected disabled>- pilih periode -</option>
                                <option value="{{ $this_year }}">{{ $this_year }}</option>
                                <option value="{{ $this_year + 1 }}">{{ $this_year + 1 }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Karyawan</label>
                            <select name="user_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama karyawan -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
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
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah Jatah Cuti (hari)</label>
                            <input type="number" name="jumlah" class="form-control" required min="1">
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('admin-konfigurasi_cuti.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

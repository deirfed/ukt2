@extends('layout.base')

@section('title-head')
    <title>
        Absensi | Tambah Data Absensi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Absensi</li>
            <li class="breadcrumb-item active">Tambah Data Absensi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Absensi</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" autocomplete="off" value="{{ auth()->user()->name }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Tipe Absensi</label>
                            <select name="jenis_absensi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih tipe absensi -</option>
                                @foreach ($jenis_absensi as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" placeholder="Tanggal Absensi" onfocus="(this.type='date')"
                                onblur="(this.type='text')" class="form-control" name="tanggal" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Masuk</label>
                            <input type="text" placeholder="Jam Masuk" onfocus="(this.type='time')"
                                onblur="(this.type='text')" class="form-control" name="jam_masuk" autocomplete="off"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Keluar</label>
                            <input type="text" placeholder="Jam Keluar" onfocus="(this.type='time')"
                                onblur="(this.type='text')" class="form-control" name="jam_keluar" autocomplete="off"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="">Photo Masuk</label>
                            <input type="file" class="form-control" name="photo_masuk" autocomplete="off"
                                accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="">Photo Keluar</label>
                            <input type="file" class="form-control" name="photo_keluar" autocomplete="off"
                                accept="image/*" required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('absensi.my_index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

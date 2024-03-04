@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Gudang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item">Gudang</li>
            <li class="breadcrumb-item active">Distribusi Barang</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Distribusi Barang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">No. Kontrak</label>
                            <select name="no_kontrak" class="form-control" required>
                                <option value="" selected disabled>- pilih no kontrak -</option>
                                <option value="">S.49850/DKI (Pengadaan Consumable Kepulauan Seribu (2023))</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilih Gudang</label>
                            <select name="gudang" class="form-control" required>
                                <option value="" selected disabled>- pilih gudang -</option>
                                <option value="">Gudang Pulau Tidung</option>
                                <option value="">Gudang Pulau Untung Jawa</option>
                                <option value="">Gudang Pulau Karya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">List Barang</label>
                            <select name="list_barang" class="form-control" required>
                                <option value="" selected disabled>- pilih gudang -</option>
                                <option value="">Semen (Stock: 1000)</option>
                                <option value="">Cat Kayu (Stock: 2000)</option>
                                <option value="">Kabel NYM (Stock: 500)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah yang Didistribusikan</label>
                            <input type="text" class="form-control" id="sum" name="sum"
                                placeholder="Masukkan Jumlah"  required>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('pengadaan.list-data') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Transaksi Barang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item">Barang</li>
            <li class="breadcrumb-item active">Transaksi Barang</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="#" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title text-center">Form Pemakaian Barang</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="gudang">Lokasi</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder=""
                                value="Gudang Pencahayaan Pulau Tidung" required disabled>
                        </div>
                        <div class="form-group">
                            <label for="koordinator">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="Ahmad Putra Jokowi" required disabled>
                        </div>
                        <div class="form-group">
                            <div class="row no-gutters d-grid">
                                <div class="col-xl-4 col-md-4">
                                    <select name="periode" class="form-control" required>
                                        <option value="" selected disabled>- pilih barang -</option>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-md-4">
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Masukkan Jumlah" required>
                                </div>
                                <div class="col-xl-4 col-md-4">
                                    <button class="form-control btn btn-primary">+Tambah Data</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="list">List Barang</label>
                            <div class="card">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="text-center">1</th>
                                            <th class="text-center">Semen</th>
                                            <th class="text-center">30 Zak</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">1</th>
                                            <th class="text-center">Semen</th>
                                            <th class="text-center">30 Zak</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">1</th>
                                            <th class="text-center">Semen</th>
                                            <th class="text-center">30 Zak</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lampiran">Dokumentasi (Foto jadi 1 dikumpulkan)</label>
                            <input type="file" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="form-group">
                            <label for="gudang">Catatan</label>
                            <textarea name="remark" placeholder="Nama pekerjaan (opsional)" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit Pemakaian</button>
                            <a href="{{ route('provinsi.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

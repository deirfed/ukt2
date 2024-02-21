@extends('layout.base')

@section('title-head')
    <title>
        Dashboard | Data Assets
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item active">Data Assets</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="user-details h-320">
                <div class="user-thumb">
                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                        alt="Admin Template" />
                </div>
                <h4>{{ auth()->user()->name }}</h4>
                <h5>10926</h5>
                <br>
                <h5>Seksi Pencahayaan</h5>
                <p>Pulau Tidung</p>
            </div>
        </div>
        <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card h-320">
                <div class="card-header">
                    <h5>Informasi Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="name" placeholder="Nama"
                                    value={{ auth()->user()->name }}>

                            </div>
                            <div class="form-group">
                                <label for="eMail">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                    value={{ auth()->user()->email }} disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone">Nomer HP</label>
                                <input type="text" class="form-control" id="no_hp" placeholder="Nomer HP"
                                    value="0808080080808">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="seksi">Seksi</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Seksi"
                                    value="Pencahayaan" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ciTy">Kepala Koordinator</label>
                                <input type="koordinator" class="form-control" id="pulau" placeholder="Koordinator"
                                    value="Abdul Kohar Mudzakhir" disabled>
                            </div>
                            <div class="form-group">
                                <label for="pulau">Pulau Okupansi/Tempat Bertugas</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Pulau"
                                    value="Pulau Tidung" disabled>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="text-right">
                                <button type="button" id="submit" name="submit" class="btn btn-dark">Batal</button>
                                <button type="button" id="submit" name="submit" class="btn btn-success">Submit
                                    Perubahan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="sale-num">
                    <h4>12/12</h4>
                    <p>Sisa Cuti Tahun Ini</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="fa fa-check"></i>
                </div>
                <div class="sale-num">
                    <h4>250</h4>
                    <p>Daftar Laporan Kinerja Saya</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-shopping-bag1"></i>
                </div>
                <div class="sale-num">
                    <h4>XX</h4>
                    <p>Dev Proccess</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-activity"></i>
                </div>
                <div class="sale-num">
                    <h4>XX</h4>
                    <p>Dev Proccess</p>
                </div>
            </div>
        </div>
    </div>
@endsection

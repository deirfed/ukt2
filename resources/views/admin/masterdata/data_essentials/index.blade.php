@extends('layout.base')

@section('title-head')
    <title>
        Dashboard | Data Essentials
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item active">Data Essentials Dashboard</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div>
                <div>
                    <h5>Masterdata Essentials</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('user.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $users }}</h3>
                        <p>Users</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('provinsi.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $provinsi }}</h3>
                        <p>Provinsi</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('walikota.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $walikota }}</h3>
                        <p>Kota / Kabupaten</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('kecamatan.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $kecamatan }}</h3>
                        <p>Kecamatan</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('kelurahan.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $kelurahan }}</h3>
                        <p>Kelurahan</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('pulau.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $pulau }}</h3>
                        <p>Pulau</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('unitkerja.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $unitkerja }}</h3>
                        <p>Unit Kerja</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('seksi.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $seksi }}</h3>
                        <p>Seksi</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('tim.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $tim ?? 0 }}</h3>
                        <p>Tim</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('role.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $role }}</h3>
                        <p>Role</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('jabatan.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $jabatan ?? 0 }}</h3>
                        <p>Jabatan</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('employee-type.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $employee_type ?? 0 }}</h3>
                        <p>Employee Type</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('kategori.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $kategori ?? 0 }}</h3>
                        <p>Kategori</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('jenis_cuti.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $jenis_cuti ?? 0 }}</h3>
                        <p>Jenis Cuti</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('jenis_absensi.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $jenis_absensi ?? 0 }}</h3>
                        <p>Jenis Absensi</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('kontrak.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $kontrak ?? 0 }}</h3>
                        <p>Kontrak</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('gudang.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $gudang ?? 0 }}</h3>
                        <p>Gudang</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

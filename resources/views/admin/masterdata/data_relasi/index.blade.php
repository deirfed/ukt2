@extends('layout.base')

@section('title-head')
    <title>
        Dashboard | Masterdata Relasi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item active">Data Relasi Dashboard</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div>
                <div>
                    <h5>Masterdata Relasi</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('role_user.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $role_user ?? 0 }}</h3>
                        <p>Role User</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('area.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $area ?? 0 }}</h3>
                        <p>Area</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('struktur.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $struktur ?? 0 }}</h3>
                        <p>Struktur</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('formasi_tim.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $formasi_tim ?? 0 }}</h3>
                        <p>Formasi Tim</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('konfigurasi_cuti.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $konfigurasi_cuti ?? 0 }}</h3>
                        <p>Konfigurasi Cuti</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    {{-- <div class="row gutters">
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
    </div> --}}
@endsection

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
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="{{ route('provinsi.index') }}">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>{{ $provinsi }}</h3>
                        <p>Daftar Provinsi</p>
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
                        <p>Walikota / Kab.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3></h3>
                        <p>Division List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3></h3>
                        <p>Department List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Section List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Management Users</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div>
                <div>
                    <h5>Masterdata Administration</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Shift List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Area List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Region List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Line List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Location List</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-12">
            <a href="#">
                <div class="info-tiles">
                    <div class="info-icon">
                        <i class="fa fa-database"></i>
                    </div>
                    <div class="stats-detail">
                        <h3>1</h3>
                        <p>Role List</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

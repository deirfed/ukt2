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
            <li class="breadcrumb-item active">Data Assets Dashboard</li>
        </ol>
    </div>
@endsection

@section('content')
<div class="row gutters">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="card text-center">
            <div class="card-header">
                <div class="card-title">RBM</div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Railway Building Maintenance</h5>
                <p class="card-text">Dashboard Departement RBM </p>
                <a href="#" class="btn btn-primary">Explore</a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="card text-center">
            <div class="card-header">
                <div class="card-title">CPWTM</div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Civil Permanent Way Technology Maintenance</h5>
                <p class="card-text">Dashboard Departement CPWTM</p>
                <a href="#" class="btn btn-primary">Explore</a>
            </div>
        </div>
    </div>
</div>
<div class="row gutters">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="card text-center">
            <div class="card-header">
                <div class="card-title">RSISM</div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Railway System Integration & Signalling Maintenance</h5>
                <p class="card-text">Dashboard Departement RSISM </p>
                <a href="#" class="btn btn-primary">Explore</a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="card text-center">
            <div class="card-header">
                <div class="card-title">RETM</div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Railway Electricity Technology Maintenance</h5>
                <p class="card-text">Dashboard Departement RETM</p>
                <a href="#" class="btn btn-primary">Explore</a>
            </div>
        </div>
    </div>
</div>
@endsection

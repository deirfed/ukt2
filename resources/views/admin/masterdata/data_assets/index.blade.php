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
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
        <div class="card text-center">
            <div class="card-header">
                <div class="card-title">PULAU</div>
            </div>
            <div class="card-body">
                {{-- <h5 class="card-title">Asset Pulau dan Detail</h5> --}}
                <p class="card-text">Asset Detail Setiap Pulau</p>
                <a href="{{ route('pulau.index') }}" class="btn btn-primary">Explore</a>
            </div>
        </div>
    </div>
</div>
@endsection

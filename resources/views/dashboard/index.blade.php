@extends('layout.base')

@section('title-head')
    <title>
        Admin Dashboard | OMBAK Kep. Seribu
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Admin Dashboard</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-eye1"></i>
                </div>
                <div class="sale-num">
                    <h4>98,000</h4>
                    <p>Visitors</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-shopping-cart1"></i>
                </div>
                <div class="sale-num">
                    <h4>22,000</h4>
                    <p>Orders</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-shopping-bag1"></i>
                </div>
                <div class="sale-num">
                    <h4>$70,000</h4>
                    <p>Sales</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-activity"></i>
                </div>
                <div class="sale-num">
                    <h4>$25,000</h4>
                    <p>Expenses</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row gutters">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-right">
                        <div class="col-md-6">
                            <div class="card-title">Absensi Hari Ini</div>
                            <p>{{ \Carbon\Carbon::now()->addHours(7)->format('d F Y H:i A') }}
                            </p>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="chartist donut-scheme-two">
                        <div class="pieChartCustomers"></div>
                    </div>
                    <!-- Row starts -->
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-a">
                                <i class="icon-opacity"></i>
                                <h6>Sudah Absen</h6>
                                <h3>450</h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-b">
                                <i class="icon-opacity"></i>
                                <h6>Belum Absen</h6>
                                <h3>900</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Emails</div>
                </div>
                <div class="card-body">
                    <div class="chartist donut-scheme-two">
                        <div class="pieChartEmails"></div>
                    </div>
                    <!-- Row starts -->
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-a">
                                <i class="icon-opacity"></i>
                                <h6>Sent</h6>
                                <h3>550</h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-b">
                                <i class="icon-opacity"></i>
                                <h6>Opened</h6>
                                <h3>800</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
        </div>
    </div>
@endsection

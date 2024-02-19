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
                    <i class="icon-user"></i>
                </div>
                <div class="sale-num">
                    <h4>250</h4>
                    <p>Total Pegawai</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-user-minus"></i>
                </div>
                <div class="sale-num">
                    <h4>0</h4>
                    <p>Personel Alfa/Izin/Tidak Hadir Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-shopping-bag1"></i>
                </div>
                <div class="sale-num">
                    <h4>250</h4>
                    <p>Personel Tersedia Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="info-stats4">
                <div class="info-icon">
                    <i class="icon-activity"></i>
                </div>
                <div class="sale-num">
                    <h4>12</h4>
                    <p>Laporan Temuan Hari Ini</p>
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
                            <div class="card-title">Absensi Akumulatif Hari Ini</div>
                            <p>{{ \Carbon\Carbon::now()->addHours(7)->format('d F Y H:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chartist donut-scheme-two">
                        <div id="absensiAkumulatif"></div>
                    </div>
                    <!-- Row starts -->
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-a">
                                <i class="icon-opacity"></i>
                                <h6>Sudah Absen</h6>
                                <h3>100 Pegawai</h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-b">
                                <i class="icon-opacity"></i>
                                <h6>Belum Absen</h6>
                                <h3>30 Pegawai</h3>
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
                    <div class="row align-items-right">
                        <div class="col-md-6">
                            <div class="card-title">Rekapitulasi Temuan Per Bulan</div>
                            <p>{{ \Carbon\Carbon::now()->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chartist donut-scheme-two">
                        <div id="chartAbsensiBulanan"></div>
                    </div>
                    <!-- Row starts -->
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-a">
                                <i class="icon-opacity"></i>
                                <h6>Open</h6>
                                <h3>99,8%</h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-b">
                                <i class="icon-opacity"></i>
                                <h6>Close</h6>
                                <h3>0,02%</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-right">
                        <div class="col-md-6">
                            <div class="card-title">Informasi Pulau & Update Terkini</div>
                            <p>{{ \Carbon\Carbon::now()->addHours(7)->format('d F Y H:i A') }}
                            </p>
                            <div class="dropdown show">
                                <a class="btn btn-dark dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pilih Pulau
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#">Pulau Tidung</a>
                                    <a class="dropdown-item" href="#">Pulau Untung Jawa</a>
                                    <a class="dropdown-item" href="#">Pulau Pari</a>
                                    <a class="dropdown-item" href="#">Pulau Pramuka</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12">
                            <h5>Pulau Tidung</h5>
                            <div class="svg-container">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 584.61 338.44">
                                    <defs>
                                        <style>
                                            .cls-1 {
                                                fill: #034ea2;
                                            }
                                        </style>
                                    </defs>
                                    <path class="cls-1"
                                        d="M583.71,329.13S574.57,324,572.86,320s-5.15-13.71-6.29-15.43-4-22.86-6.28-29.71-6.86-19.43-9.72-23.43-5.71-2.29-16-8-10.86-5.14-14.28-8-26.29-8.57-28-10.86-21.72-21.14-21.72-21.14-5.14,0-8.57-1.72-13.14-1.71-14.29-3.42S436.29,184,435.14,180s-15.43-11.43-16.57-13.14-2.14-16.71-4.14-20.53q-5.69,0-11.37-.27l-8.49,17.37L380.86,188l-8.57,4L360.86,209.7l-18.29,25.72H331.71l-4-11.43-4.57-4.57-12.57,16L303.14,232l2.86-8.57H291.71L283.14,232v-7.43L280.29,220H240.86l-17.15-56.57-84,4a71.27,71.27,0,0,1-5.14-7.43c-1.14-2.29-.57-15.43-11.43-29.14s-10.28-2.86-14.28-1.72,3.43,14.29,7.43,19.43A24.36,24.36,0,0,1,120.86,160s-5.72,15.43-10.29,15.43-21.14-1.72-22.86-2.29-5.71-2.28-6.85-4.57-2.86-6.28-6.29-26.28-.57-4.58-4-10.86-8-1.14-8-1.14H35.71c-3.42,0-2.85,1.71-4,4s-1.14,14.85-1.14,20.57,7.43,17.14,8,24,0,16-1.71,20-3.43,8-3.43,8-5.14,9.14-8.57,12.57S18.57,232,11.71,242.28s0,22.28,0,28,2.86,13.14,2.86,15.42,4.57,12,4.57,11.94,4,12.64,2.42,15.49,3.3,13.72,1,16,0,14.86,0,17.15V360L26,376.56l5.14,25.72v14.85l4,9.15L38,433.13l7.43,4,12,2.86S78,443.42,83.14,441.7s6.29,0,14.86-7.42,6.86-2.86,9.71-7.43,11.43-2.29,16-5.15,6.29,4,6.29,4l4,2.86s14.29,8.57,17.14,9.14,18.29,4.58,20.57,1.72,4.58-.57,7.43-10.86,2.86-1.14,2.86-1.14,12,4,14.29,4.57,9.14,2.86,9.14,2.86a17,17,0,0,0,6.28-7.43c2.29-5.14,6.86-5.14,8-6.86s6.86-.57,9.15-1.71S241.43,420,241.43,420l13.14,8.57,5.72,6.29,12,8.57s14.85,8,18.28,8,14.29,6.28,14.29,6.28,16.57,4.58,18.85,4.57,12.58.58,14.86-.57,13.14,1.72,17.72,0,12-1.71,13.71-4,7.43-1.71,9.14-5.14,10.86,1.72,13.72,0,13.14-2.86,18.28-7.43S420.29,440,426,432.56s4.57-4.57,5.71-9.14,2.86-3.43,4-9.14,0-5.72-1.14-12-1.71-5.15-2.28-12,0,0,.57-4.52,2.85-2.34,4.57-5.2,2.86-.57,5.14-1.14,22.86,1.14,25.14,1.14,13.72,1.14,15.43,1.14,15.43,1.72,22.29,1.15,20,3.43,21.71,2.85,7.43-1.14,9.15-4.57,2.28-4,6.85-11.43,5.72-3.42,8-4,19.43,1.72,29.15,0,7.42-3.42,8-8S589.43,352,590,348s3.28-11.43,3.28-13.71S583.71,329.13,583.71,329.13Z"
                                        transform="translate(-8.67 -123.98)" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h5>Informasi & Detail Pulau</h5>
                            <!-- Row start -->
                            <div class="row gutters">
                                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="info-tiles">
                                        <div class="info-icon">
                                            <i class="icon-account_circle"></i>
                                        </div>
                                        <div class="stats-detail">
                                            <h3>1.230</h3>
                                            <p>Total Populasi</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="info-tiles">
                                        <div class="info-icon">
                                            <i class="icon-explore"></i>
                                        </div>
                                        <div class="stats-detail">
                                            <h3>2930 m3</h3>
                                            <p>Luas Pulau</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="info-tiles">
                                        <div class="info-icon">
                                            <i class="icon-account_circle"></i>
                                        </div>
                                        <div class="stats-detail">
                                            <h3>120</h3>
                                            <p>Total PJLP</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="info-tiles">
                                        <div class="info-icon">
                                            <i class="icon-blur_on"></i>
                                        </div>
                                        <div class="stats-detail">
                                            <h3>260</h3>
                                            <p>Asset Lampu Jalan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="info-tiles">
                                        <div class="info-icon">
                                            <i class="icon-check_circle"></i>
                                        </div>
                                        <div class="stats-detail">
                                            <h3>130m'</h3>
                                            <p>Asset Jalan</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                                    <div class="info-tiles">
                                        <div class="info-icon">
                                            <i class="icon-check_circle"></i>
                                        </div>
                                        <div class="stats-detail">
                                            <h3>37489</h3>
                                            <p>Asset Tetrapod</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row ends -->
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <h3>Laporan Kerusakan Fasilitas</h3>
                            <div class="card h-280 agenda-bg">
                                <div class="card-body">
                                    <div class="agenda">
                                        <div class="todays-date">
                                            <h5>Daftar Laporan - <span class="date" id="todays-date"></span></h5>
                                        </div>
                                        <ul class="agenda-list">
                                            <li>
                                                <span class="bullet">&nbsp;</span>
                                                <div class="details">
                                                    <p>Kerusakan Box Culvert di Depan Masjid Ar-Rahman</p>
                                                    <small> Entry Laporan: 09:00 16/2/2024 | Follow Up Laporan: 13:12
                                                        10/2/2024 </small>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="bullet">&nbsp;</span>
                                                <div class="details">
                                                    <p>Kerusakan Irigasi di Depan Posyandu</p>
                                                    <small> Entry Laporan: 09:00 16/2/2024 | Follow Up Laporan: 13:12
                                                        10/2/2024 </small>
                                                </div>
                                            </li>
                                            <li>
                                                <span class="bullet">&nbsp;</span>
                                                <div class="details">
                                                    <p>Kerusakan Pralon Pembuangan Air di Area Rumah Warga</p>
                                                    <small> Entry Laporan: 09:00 16/2/2024 | Follow Up Laporan: 13:12
                                                        10/2/2024 </small>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        Highcharts.chart('absensiAkumulatif', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: '',
                align: 'center',
                verticalAlign: 'middle',
                y: 60
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%'],
                    size: '110%'
                }
            },
            series: [{
                type: 'pie',
                name: 'Pie Absensi',
                innerSize: '50%',
                data: [{
                        name: 'Sudah Absen',
                        y: 73.86,
                        color: '#034ea2'
                    },
                    {
                        name: 'Belum Absen',
                        y: 11.97,
                        color: '#cc2626'
                    }
                ]
            }]
        });

        Highcharts.chart('chartAbsensiBulanan', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                align: 'left'
            },
            subtitle: {
                text: '' +
                    '',
                align: 'left'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'August', 'Sept', 'Oct', 'Nov',
                    'Dec'
                ],
                crosshair: true,
                accessibility: {
                    description: 'Months'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Temuan'
                }
            },
            tooltip: {
                valueSuffix: ' Temuan'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                    name: 'Temuan Open',
                    data: [10, 23, 13, 10, 22, 21, 12, 13, 19, 14, 23, 45],
                    color: '#034ea2',
                },
                {
                    name: 'Temuan Close',
                    data: [4, 5, 17, 21, 3, 23, 12, 12, 9, 12, 12, 19],
                    color: '#cc2626'
                }
            ]
        });
    </script>
@endsection

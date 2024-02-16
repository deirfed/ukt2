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
                            <div class="card-title">Rekap Absensi Bulanan</div>
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
                                <h6>Persentase Kehadiran</h6>
                                <h3>99,8%</h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-b">
                                <i class="icon-opacity"></i>
                                <h6>Persentase Ketidakhadiran</h6>
                                <h3>0,02%</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
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
                max: 250,
                title: {
                    text: 'Personel'
                }
            },
            tooltip: {
                valueSuffix: ' Personel'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                    name: 'Hadir',
                    data: [250, 250, 250, 245, 242, 231, 234, 235, 237, 239, 249, 230],
                    color: '#034ea2',
                },
                {
                    name: 'Tidak Hadir',
                    data: [0, 0, 0, 5, 3, 23, 12, 12, 9, 12, 12, 19],
                    color: '#cc2626'
                }
            ]
        });
    </script>
@endsection

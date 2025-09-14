@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Admin Dashboard | UKT2.ORG Kep. Seribu
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('admin-user.index') }}">
                <div class="info-stats4">
                    <div class="info-icon">
                        <i class="icon-user"></i>
                    </div>
                    <div class="sale-num">
                        <h4>{{ $totalUser }}</h4>
                        <p>Total Pengguna Aktif (Tahun {{ $tahun }})</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('admin-absensi.index') }}">
                <div class="info-stats4">
                    <div class="info-icon">
                        <i class="icon-database"></i>
                    </div>
                    <div class="sale-num">
                        <h4>{{ $tersedia }} / {{ $totalUser }} ({{ number_format($persentase, 0) }}%)
                        </h4>
                        <p>PJLP Hari Ini</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('admin-kinerja.index') }}">
                <div class="info-stats4">
                    <div class="info-icon">
                        <i class="icon-shopping-bag1"></i>
                    </div>
                    <div class="sale-num">
                        <h4>{{ $jumlahKinerja }}</h4>
                        <p>Total Input Kinerja (Tahun {{ $tahun }})</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('admin-cuti.index') }}">
                <div class="info-stats4">
                    <div class="info-icon">
                        <i class="icon-activity"></i>
                    </div>
                    <div class="sale-num">
                        <h4>{{ $cutiHariIni }}</h4>
                        <p>PJLP Cuti Hari Ini</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-right">
                        <div class="col-md-6">
                            <div class="card-title">Pintasan</div>
                            <p id="jam">Pintasan Generate Report PDF</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="container-fluid">
                            <div class="row gutters">
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="doc-block">
                                        <div class="doc-icon">
                                            <i class="fa fa-calendar fa-2x"></i>
                                        </div>
                                        <div class="doc-title text-white">Generate Report Absensi PJLP</div>
                                        <div class="dropdown">
                                            <button class="btn btn-dark mr-2 mb-2 mb-sm-0 text-white" data-toggle="modal"
                                                data-target="#modalDownloadPDFAbsensi" aria-haspopup="true"
                                                aria-expanded="false" title="Export">
                                                <i class="fa fa-paper-plane"></i> Export PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="doc-block">
                                        <div class="doc-icon">
                                            <i class="fa fa-list fa-2x"></i>
                                        </div>
                                        <div class="doc-title text-white">Generate Report Kegiatan PJLP</div>
                                        <div class="dropdown">
                                            <button class="btn btn-dark mr-2 mb-2 mb-sm-0 text-white" href="#"
                                                id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" title="Export">
                                                <i class="fa fa-paper-plane"></i> Export PDF
                                            </button>

                                            <ul class="dropdown-menu" aria-labelledby="dashboardsDropdown">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                        data-target="#modalDownloadPDFKegiatanPersonel">
                                                        <i class="fa fa-file-pdf text-danger"></i> PDF per Personil
                                                    </a>
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
    </div>

    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-right">
                        <div class="col-md-6">
                            <div class="card-title">Absensi Akumulatif Hari Ini</div>
                            <p id="jam">{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Pilih Tanggal</label>
                        <input type="date" id="tanggal" class="form-control" value="{{ now()->toDateString() }}">
                    </div>
                    <div class="chartist donut-scheme-two">
                        <div id="absensiAkumulatif"></div>
                    </div>
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-a">
                                <i class="icon-opacity"></i>
                                <h6>Sudah Absen</h6>
                                <h3 id="sudah-absen">0 Pegawai</h3>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="info-stats3 shade-one-b">
                                <i class="icon-opacity"></i>
                                <h6>Belum Absen</h6>
                                <h3 id="belum-absen">0 Pegawai</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ABSENSI --}}
    {{-- BEGIN: Konfirmasi PDF --}}
    <div id="modalDownloadPDFAbsensi" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Export Laporan Absensi</h5>
                </div>
                <div class="modal-body">
                    <form id="formPDFAbsensi" action="{{ route('simoja.kasi.absensi.export.pdf') }}" method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Personel</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" selected disabled>- Pilih Personel -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $user_id) selected @endif>{{ $item->name }} -
                                                {{ $item->nip ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Periode</label>
                                    <input type="month" class="form-control" name="periode"
                                        value="{{ $periode }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="formPDFAbsensi" formtarget="_blank"
                        class="btn btn-primary">Buat</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi PDF --}}



    {{-- KEGIATAN --}}
    {{-- BEGIN: Konfirmasi PDF --}}
    <div id="modalDownloadPDFKegiatanPersonel" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Export Laporan Kinerja</h5>
                </div>
                <div class="modal-body">
                    <form id="formPDFKegiatanPersonel" action="{{ route('simoja.kasi.kinerja.export.pdf') }}"
                        method="GET">
                        @csrf
                        @method('GET')
                        <div class="form-row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="">Personil</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" selected disabled>- Pilih Personil -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == $user_id) selected @endif>{{ $item->name }} -
                                                {{ $item->nip ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <label for="periode">Periode</label>
                        <div class="form-row gutters">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $start_date }}"
                                        name="start_date" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="date" class="form-control" value="{{ $end_date }}"
                                        name="end_date" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Tutup</button>
                    <button type="submit" form="formPDFKegiatanPersonel" formtarget="_blank"
                        class="btn btn-primary">Buat</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Konfirmasi PDF --}}
@endsection

@section('javascript')
    <script>
        // GRAFIK ABSENSI
        function loadAbsensi(tanggal) {
            fetch("{{ url('/getDataAbsensi') }}?tanggal=" + tanggal)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("sudah-absen").innerText = data.sudahAbsen + " Pegawai";
                    document.getElementById("belum-absen").innerText = data.belumAbsen + " Pegawai";

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
                            name: 'Chart Absensi',
                            innerSize: '50%',
                            data: [{
                                    name: 'Sudah Absen',
                                    y: data.sudahAbsen,
                                    color: '#034ea2'
                                },
                                {
                                    name: 'Belum Absen',
                                    y: data.belumAbsen,
                                    color: '#cc2626'
                                }
                            ]
                        }]
                    });
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            let today = document.getElementById("tanggal").value;
            loadAbsensi(today);

            document.getElementById("tanggal").addEventListener("change", function() {
                loadAbsensi(this.value);
            });
        });
    </script>
@endsection

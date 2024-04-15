@extends('layout.base_user')

@section('title-head')
    <title>
        Dashboard | Kepala Seksi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.kasi.index') }}">Kinerja</a></li>
            <li class="breadcrumb-item active">Daftar Performance Seksi {{ auth()->user()->struktur->seksi->name }}</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-{{ auth()->user()->struktur->seksi->id == 1 ? '12' : '6' }} col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 style="text-decoration: underline">Grafik Performance Absensi</h4>
                    <p class="ml-3 mb-2">
                        Update {{ \Carbon\Carbon::now()->format('F Y') }}
                    </p>
                    <div id="chartAbsensi"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-{{ auth()->user()->struktur->seksi->id == 1 ? '12' : '6' }} col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4 style="text-decoration: underline">Grafik Performance Kinerja</h4>
                    <p class="ml-3 mb-2">
                        Update {{ \Carbon\Carbon::now()->format('F Y') }}
                    </p>
                    <div id="chartKinerja"></div>
                </div>
            </div>
        </div>

    </div>
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Pulau</th>
                                    <th class="text-center">Absen Datang</th>
                                    <th class="text-center">Absen Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($absensi as $nama => $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $nama }}</td>
                                        <td class="text-center">{{ $users->where('name', $nama)->first()->jabatan->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $users->where('name', $nama)->first()->area->pulau->name }}
                                        </td>
                                        <td class="text-center @if ($data['absen_masuk'] == 0) text-danger @endif">
                                            {{ $data['absen_masuk'] }} Input</td>
                                        <td class="text-center @if ($data['absen_pulang'] == 0) text-danger @endif">
                                            {{ $data['absen_pulang'] }} Input</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Pulau</th>
                                    <th class="text-center">Data Input Kinerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kinerja as $nama => $data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $nama }}</td>
                                        <td class="text-center">{{ $users->where('name', $nama)->first()->jabatan->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ $users->where('name', $nama)->first()->area->pulau->name }}
                                        </td>
                                        <td class="text-center @if ($data['kinerja'] == 0) text-danger @endif">
                                            {{ $data['kinerja'] }} Input</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        Highcharts.chart('chartAbsensi', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                align: 'left'
            },
            xAxis: {
                categories: {!! json_encode(array_keys($absensi)) !!},
                crosshair: true,
                accessibility: {
                    description: 'Users'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ' Input (Jumlah)'
                }
            },
            tooltip: {
                valueSuffix: ' Data'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                    name: 'Absen Masuk',
                    data: {!! json_encode(array_column($absensi, 'absen_masuk')) !!},
                    color: '#034ea2'
                },
                {
                    name: 'Absen Pulang',
                    data: {!! json_encode(array_column($absensi, 'absen_pulang')) !!}
                }
            ]
        });

        Highcharts.chart('chartKinerja', {
            chart: {
                type: 'column'
            },
            title: {
                text: '',
                align: 'left'
            },
            subtitle: {
                text: ' ' +
                    '',
                align: 'left'
            },
            xAxis: {
                categories: {!! json_encode(array_keys($kinerja)) !!},
                crosshair: true,
                accessibility: {
                    description: 'Users'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Input (Jumlah)'
                }
            },
            tooltip: {
                valueSuffix: ' Data'
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Input Kinerja Harian',
                data: {!! json_encode(array_column($kinerja, 'kinerja')) !!},
                color: '#034ea2'
            }, ]
        });
    </script>
@endsection

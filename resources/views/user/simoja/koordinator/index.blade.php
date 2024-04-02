@extends('layout.base_user')

@section('title-head')
    <title>
        Dashboard Simoja | Koordinator
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard Simoja Koordinator</li>
    </div>
@endsection


@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.koordinator.absensi-create') }}">
                                <div class="launch-box h-180">
                                    <h3>Absensi Saya</h3>
                                    <i class="fa fa-id-card"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3 class="jam"></h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.koordinator.kinerja-create') }}">
                                <div class="launch-box h-180">
                                    <h3>Kinerja Saya</h3>
                                    <i class="fa fa-suitcase"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>10 Laporan</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.koordinator.cuti-create') }}">
                                <div class="launch-box h-180">
                                    <h3>Cuti Saya</h3>
                                    <i class="fa fa-calendar-times"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>Sisa Cuti : 12</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.koordinator.absensi.tim') }}">
                                <div class="launch-box-2 h-180">
                                    <h3>Absensi Tim Saya</h3>
                                    <i class="fa fa-users"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>Lihat Daftar</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.koordinator.kinerja.tim') }}">
                                <div class="launch-box-2 h-180">
                                    <h3>Kinerja Tim Saya</h3>
                                    <i class="fa fa-line-chart"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>Lihat Daftar</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.koordinator.cuti.tim') }}">
                                <div class="launch-box-2 h-180">
                                    <h3>Cuti Tim Saya</h3>
                                    <i class="fa fa-calendar-minus"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>Lihat Daftar</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 1100px) {
            h3 {
                font-size: 15px;
            }
        }
    </style>
@endsection


@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }

        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);

            document.querySelectorAll('.jam').forEach(function(element) {
                element.innerHTML = h + ":" + m + ":" + s + " WIB";
            });

            setTimeout(startTime, 1000);
        }


        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            };
            return i;
        }

        $(document).ready(function() {
            startTime();
        });
    </script>
@endsection

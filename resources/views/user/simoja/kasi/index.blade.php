@extends('layout.base_user')

@section('title-head')
    <title>
        Dashboard | Kepala Seksi
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard Simoja Kepala Seksi</li>
    </div>
@endsection


@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.kasi.absensi') }}">
                                <div class="launch-box h-180">
                                    <h3>Lihat Daftar Absensi</h3>
                                    <i class="fa fa-id-card"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3 class="jam"></h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.kasi.kinerja') }}">
                                <div class="launch-box h-180">
                                    <h3>Lihat Daftar Kinerja</h3>
                                    <i class="fa fa-suitcase"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>10 Laporan</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.kasi.cuti') }}">
                                <div class="launch-box h-180">
                                    <h3>Lihat Daftar Cuti</h3>
                                    <i class="fa fa-calendar-times"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>1 Pengajuan</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.kasi.cuti.approval') }}">
                                <div class="launch-box h-180">
                                    <h3>Lihat Daftar Approval Cuti</h3>
                                    <i class="fa fa-calendar-times"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h3>1 Pengajuan</h3>
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
                element.innerHTML = h + ":" + m + ":" + s + ' WIB';
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

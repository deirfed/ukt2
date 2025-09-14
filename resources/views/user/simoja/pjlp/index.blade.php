@extends('layout.base_user')

@section('title-head')
    <title>
        Dashboard Simoja | PJLP
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard Simoja PJLP</li>
    </div>
@endsection


@section('content')
    <div class="row gutters d-flex justify-content-center align-item-center">
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.pjlp.absensi-create') }}">
                                <div class="launch-box h-180">
                                    <h3>Absensi Saya</h3>
                                    <i class="fa fa-id-card"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h5 id="jam"></h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.pjlp.kinerja-create') }}">
                                <div class="launch-box h-180">
                                    <h3>Kinerja</h3>
                                    <i class="fa fa-suitcase"></i>
                                    <p>{{ $tanggal }}</p>
                                    <h5>Lihat Data Kinerja</h5>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <a href="{{ route('simoja.pjlp.cuti-create') }}">
                                <div class="launch-box h-180">
                                    <h3>Cuti Saya</h3>
                                    <i class="fa fa-calendar-times"></i>
                                    <p>{{ $tanggal }}</p>
                                    @if ($sisa_cuti > 0)
                                        <h5>Sisa Cuti: {{ $sisa_cuti }}</h5>
                                    @else
                                        <h5>Kuota Cuti Habis</h5>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 576px) {
            h3 {
                font-size: 15px;
            }
        }
    </style>

    <div class="modal fade" id="spModal" tabindex="-1" role="dialog" aria-labelledby="spModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-header bg-danger text-white d-flex justify-content-center">
                    <h5 class="modal-title">⚠️ Peringatan SP</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Halo <strong>{{ Auth::user()->name }}</strong>, berdasarkan catatan sistem <br>Anda memiliki
                    <b>Surat Peringatan (SP)</b>.
                    <br><br>
                    Mohon untuk lebih <span class="text-danger font-weight-bold">meningkatkan kedisiplinan</span>
                    dan <span class="text-danger font-weight-bold">ketertiban dalam absensi</span>.
                    <br><br>
                    Silakan klik tombol di bawah untuk melihat detail Surat Peringatan Anda.
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <a href="{{ route('user.profile') }}" class="btn btn-primary">
                        📄 Lihat Detail SP
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script>
        function toggleModal(id) {
            $('#id').val(id);
        }

        function startTime() {
            const today = new Date();
            const h = today.getHours();
            const m = String(today.getMinutes()).padStart(2, '0');
            const s = String(today.getSeconds()).padStart(2, '0');
            document.getElementById('jam').textContent = `${h}:${m}:${s} WIB`;
            setTimeout(startTime, 1000);
        }

        $(function() {
            startTime();
            @if ($surat_peringatan > 0)
                $('#spModal').modal('show');
            @endif
        });
    </script>
@endsection

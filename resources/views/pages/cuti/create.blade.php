@extends('layout.base')

@section('title-head')
    <title>
        Cuti | Permohonan Cuti / Izin
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Cuti</li>
            <li class="breadcrumb-item active">Permohonan Cuti / Izin</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-8 col-sm-12 col-12">
            <form action="" method="POST">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Permohonan Cuti / Izin</div>
                        <div class="warning-izin mt-3">
                            <p>*Izin Sakit wajib menyertakan Surat Keterangan Dokter</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="jenis_pengajuan">Jenis Pengajuan</label>
                                    <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan">
                                        <option value="cuti_tahunan">Cuti Tahunan</option>
                                        <option value="izin_sakit">Izin Sakit</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <label for="jenis_pengajuan">Tanggal Mulai:</label>
                                            <input type="text" class="form-control" id="tanggal_awal"
                                                placeholder="Tanggal Awal">
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <label for="jenis_pengajuan">Tanggal Akhir:</label>
                                            <input type="text" class="form-control" id="tanggal_akhir"
                                                placeholder="Tanggal Akhir">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <label for="jenis_pengajuan">Total Permohonan (Hari):</label>
                                            <input type="text" class="form-control" id="tanggal_awal"
                                                placeholder="1 Hari" value="2 Hari (dinamis sesuai tanggal, kyk di SF kita)" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="nama">Cuti Tersedia</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nama"
                                        value="12 Hari" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                <label for="catatan">Catatan:</label>
                                <textarea id="input_catatan" class="form-control" name="input_catatan" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                <label for="catatan">Lampiran:</label>
                                <div class="">
                                    <form action="/">
                                        <input type="file" id="myFile" name="filename">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2 justify-content-center d-flex">
                                <div class="row">
                                    <button class="btn btn-dark mx-2">Batal</button>
                                    <button class="btn btn-primary mx-2">Ajukan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#tanggal_awal').datepicker({
                format: 'yyyy-mm-dd',
            });
        });

        $(document).ready(function() {
            $('#tanggal_akhir').datepicker({
                format: 'yyyy-mm-dd',
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            var jenisPengajuan = document.getElementById('jenis_pengajuan');
            var warningIzinDiv = document.querySelector('.warning-izin');

            jenisPengajuan.addEventListener('change', function() {
                if (jenisPengajuan.value === 'izin_sakit') {
                    warningIzinDiv.style.display = 'block';
                } else {
                    warningIzinDiv.style.display = 'none';
                }
            });
        });
    </script>
@endsection

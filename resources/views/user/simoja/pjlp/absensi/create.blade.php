@extends('layout.base_user')

@section('title-head')
    <title>
        Absensi | Tambah Data Absensi
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.pjlp.index') }}">Absensi</a></li>
            <li class="breadcrumb-item active">Tambah Data Absensi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('simoja.pjlp.absensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <a href="{{ route('simoja.pjlp.my-absensi') }}"
                                    class="btn btn-primary btn-lg rounded w-100">
                                    <i class="fa fa-eye"></i>
                                    Lihat Daftar Absensi Saya
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('simoja.pjlp.absensi.piket.create') }}"
                                    class="btn btn-warning btn-lg rounded w-100">
                                    <i class="fa fa-plus"></i>
                                    Tambah Absensi Piket
                                </a>
                            </div>
                        </div>
                        <h4 class="text-center"><u>Form Absensi</u></h4>
                        <div class="form-group">
                            <label>Data Lengkap</label>
                            <table>
                                <tr>
                                    <td style="width: 90px">Nama</td>
                                    <td style="width: 15px">:</td>
                                    <td class="font-weight-bolder">{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <td>NIP/ID</td>
                                    <td>:</td>
                                    <td>{{ auth()->user()->nip }}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>{{ auth()->user()->jabatan->name }}</td>
                                </tr>
                                <tr>
                                    <td>Koordinator</td>
                                    <td>:</td>
                                    <td>{{ $formasi_tim->koordinator->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Seksi</td>
                                    <td>:</td>
                                    <td>{{ $formasi_tim->struktur->seksi->name }}</td>
                                </tr>
                                <tr>
                                    <td>Pulau</td>
                                    <td>:</td>
                                    <td>{{ $formasi_tim->area->pulau->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Absensi</label>
                            <input type="text" class="form-control" value="{{ $mode ?? '-' }}" disabled>
                            <input type="text" class="form-control" value="{{ $jenis_absensi->id }}"
                                name="jenis_absensi_id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" class="form-control" value="{{ $tanggal }}" autocomplete="off"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Jam</label>
                            <input type="text" id="jam" class="form-control" value="__:__ WIB" autocomplete="off"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Photo</label>
                            <input type="hidden" class="form-control input-photo" name="photo" id="photo"
                                accept="image/*" required hidden>
                            <div class="container">
                                <div class="mt-2 mx-auto" id="my_camera"></div>
                                <div class="mb-3 text-center">
                                    <div id="result">Silahkan ambil foto absen terlebih dahulu...</div>
                                </div>
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button id="takeButton" type="button" class="btn btn-warning rounded"
                                            onClick="take_snapshot()">
                                            <i class="fa fa-camera" aria-hidden="true"></i> Ambil Foto
                                        </button>
                                        <button id="retakeButton" style="display: none" type="button"
                                            class="btn btn-danger rounded" onClick="retake()">
                                            <i class="fa fa-times" aria-hidden="true"></i> Ambil Ulang Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan <span class="text-primary">(Opsional)</span></label>
                            <textarea id="catatan" class="form-control" name="catatan" rows="3"></textarea>
                            <input type="hidden" name="latitude" id="latitude" required>
                            <input type="hidden" name="longitude" id="longitude" required>
                        </div>
                        <div class="btn group-button mt-2 d-flex justify-content-end">
                            <a href="{{ route('simoja.pjlp.index') }}" class="btn btn-dark rounded me-3">
                                <i class="fa fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary rounded ml-3"
                                style="display: none">
                                <i class="fa fa-paper-plane"></i>
                                Kirim
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        Webcam.set({
            width: 300,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 50
        });

        Webcam.attach('#my_camera');

        var camera = document.getElementById('my_camera');
        var takeButton = document.getElementById('takeButton');
        var retakeButton = document.getElementById('retakeButton');
        var result = document.getElementById('result');
        var submitButton = document.getElementById('submit');

        function take_snapshot() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Simpan latitude & longitude ke input hidden
                        $('#latitude').val(parseFloat(position.coords.latitude));
                        $('#longitude').val(parseFloat(position.coords.longitude));

                        // Ambil foto setelah lokasi didapat
                        Webcam.snap(function(data_uri) {
                            $(".input-photo").val(data_uri);
                            result.innerHTML = '<img class="img-thumbnail" src="' + data_uri + '"/>';
                        });

                        Webcam.reset();
                        camera.style.display = 'none';
                        takeButton.style.display = 'none';
                        retakeButton.style.display = 'block';
                        submitButton.style.display = 'block';
                    },
                    function(error) {
                        alert("Gagal mendapatkan lokasi: " + error.message);
                    }, {
                        enableHighAccuracy: true, // Lokasi lebih presisi
                        timeout: 10000, // Tunggu max 10 detik
                        maximumAge: 0 // Jangan pakai lokasi cache
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }

        function retake() {
            // Re-attach webcam
            Webcam.attach('#my_camera');

            // Tampilkan/hilangkan tombol dan kamera
            retakeButton.style.display = 'none';
            camera.style.display = 'block';
            takeButton.style.display = 'block';
            submitButton.style.display = 'none';

            // Kosongkan preview foto
            result.innerHTML = '';

            // Kosongkan input hidden
            $(".input-photo").val('');
            $('#latitude').val('');
            $('#logitude').val('');
        }

        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);

            let jam = h + ":" + m + ":" + s + ' WIB';

            $('#jam').val(jam);

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

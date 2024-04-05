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
            <li class="breadcrumb-item">Absensi</li>
            <li class="breadcrumb-item active">Tambah Data Absensi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('simoja.koordinator.absensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('simoja.koordinator.my-absensi') }}"
                                class="btn btn-primary col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                                style="border-radius: 6px">Lihat Daftar
                                Absensi Saya</a>
                        </div>
                        <h4 class="text-center"><u>Form Absensi</u></h4>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" autocomplete="off" value="{{ auth()->user()->name }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Jabatan</label>
                            <input type="text" class="form-control" autocomplete="off"
                                value="{{ auth()->user()->jabatan->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Tim</label>
                            <input type="text" class="form-control" autocomplete="off"
                                value="{{ auth()->user()->struktur->tim->name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Tipe Absensi</label>
                            <input type="text" class="form-control" value="{{ $jenis_absensi->name }}" disabled>
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
                                    <div id="result">Silahkan ambil photo absen terlebih dahulu...</div>
                                </div>
                                <div class="text-center">
                                    <div class="btn-group">
                                        <input id="takeButton" type="button" class="btn btn-warning" value="Ambil Foto"
                                            onClick="take_snapshot()">
                                        <input id="retakeButton" style="display: none" type="button"
                                            class="btn btn-secondary" value="Ambil Ulang" onClick="retake()">
                                    </div>
                                </div>
                            </div>
                            <div class="btn group-button mt-2">
                                <button type="submit" id="submit" name="submit"
                                    class="btn btn-primary float-right ml-3">Kirim</button>
                                <a href="{{ route('simoja.koordinator.index') }}" class="btn btn-dark">Batal</a>
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
            Webcam.snap(function(data_uri) {
                $(".input-photo").val(data_uri);
                result.innerHTML = '<img class="img-thumbnail" src="' + data_uri + '"/>';
            });
            Webcam.reset();
            camera.style.display = 'none';
            takeButton.style.display = 'none';
            retakeButton.style.display = 'block';
            submitButton.style.display = 'block';
        }

        function retake() {
            Webcam.attach('#my_camera');
            retakeButton.style.display = 'none';
            camera.style.display = 'block';
            takeButton.style.display = 'block';
            result.innerHTML = '';
            submitButton.style.display = 'none';
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

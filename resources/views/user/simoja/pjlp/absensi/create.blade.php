@extends('layout.base_user')

@section('title-head')
    <title>
        Absensi | Tambah Data Absensi
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <style>
        /* wrapper kamera */
        .camera-wrapper {
            position: relative;
            width: 300px;
            height: 300px;
            margin: auto;
        }

        /* video webcam */
        #my_camera video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        /* hasil foto */
        #result img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
        }

        /* overlay scanner */
        .scanner-overlay {
            position: absolute;
            inset: 0;
            border-radius: 12px;
            pointer-events: none;
            overflow: hidden;
        }

        /* lingkaran wajah */
        .face-guide {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 180px;
            height: 180px;
            transform: translate(-50%, -50%);
            border: 3px dashed rgba(255, 255, 255, .9);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        /* animasi lingkaran */
        @keyframes pulse {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: .6;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.05);
                opacity: 1;
            }
        }

        /* scan line */
        .scan-line {
            position: absolute;
            left: 0;
            width: 100%;
            height: 3px;
            background: #00ffb3;
            box-shadow: 0 0 10px #00ffb3;
            animation: scan 2.5s linear infinite;
        }

        @keyframes scan {
            0% {
                top: 20%;
            }

            50% {
                top: 80%;
            }

            100% {
                top: 20%;
            }
        }

        /* frame corner */
        .corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 3px solid transparent;
        }

        .top-left {
            top: 10px;
            left: 10px;
            border-top-color: #00bfff;
            border-left-color: #00bfff;
        }

        .top-right {
            top: 10px;
            right: 10px;
            border-top-color: #00bfff;
            border-right-color: #00bfff;
        }

        .bottom-left {
            bottom: 10px;
            left: 10px;
            border-bottom-color: #00bfff;
            border-left-color: #00bfff;
        }

        .bottom-right {
            bottom: 10px;
            right: 10px;
            border-bottom-color: #00bfff;
            border-right-color: #00bfff;
        }
    </style>
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
                            <label>Data Lengkap:</label>
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
                        <hr>
                        <div class="form-group">
                            <label for="">Jenis Absensi:</label>
                            <input type="text" class="form-control" value="{{ $mode ?? '-' }}" disabled>
                            <input type="text" class="form-control" value="{{ $jenis_absensi->id }}"
                                name="jenis_absensi_id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal:</label>
                            <input type="text" class="form-control" value="{{ $tanggal }}" autocomplete="off"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Jam:</label>
                            <input type="text" id="jam" class="form-control" value="__:__ WIB" autocomplete="off"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label class="required">Photo:</label>
                            <input type="hidden" class="form-control input-photo" name="photo" id="photo"
                                accept="image/*" required>
                            <div class="container text-center">
                                <div class="camera-wrapper mt-2 mx-auto">
                                    <div id="my_camera"></div>
                                    <div class="scanner-overlay">
                                        <div class="face-guide"></div>
                                        <div class="scan-line"></div>
                                        <div class="corners">
                                            <div class="corner top-left"></div>
                                            <div class="corner top-right"></div>
                                            <div class="corner bottom-left"></div>
                                            <div class="corner bottom-right"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 text-center">
                                    <div id="result">Silahkan ambil foto absen terlebih dahulu...</div>
                                </div>
                                <div class="text-center">
                                    <div class="btn-group">
                                        <button id="takeButton" type="button" class="btn btn-warning rounded"
                                            onClick="take_snapshot()">
                                            <i class="fa fa-camera"></i> Ambil Foto
                                        </button>
                                        <button id="retakeButton" style="display:none" type="button"
                                            class="btn btn-danger rounded" onClick="retake()">
                                            <i class="fa fa-times"></i> Ambil Ulang Foto
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="optional" for="catatan">Catatan</label>
                            <textarea id="catatan" class="form-control" name="catatan" rows="3"></textarea>
                            <input type="hidden" name="latitude" id="latitude" required>
                            <input type="hidden" name="longitude" id="longitude" required>
                        </div>
                        <hr>
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
        document.addEventListener("DOMContentLoaded", function() {

            const camera = document.getElementById("my_camera");
            const cameraWrapper = document.querySelector(".camera-wrapper");
            const scanner = document.querySelector(".scanner-overlay");

            const takeButton = document.getElementById("takeButton");
            const retakeButton = document.getElementById("retakeButton");
            const result = document.getElementById("result");
            const submitButton = document.getElementById("submit");

            const photoInput = document.getElementById("photo");
            const latitudeInput = document.getElementById("latitude");
            const longitudeInput = document.getElementById("longitude");

            /* ==============================
               INIT CAMERA
            ============================== */
            function initCamera() {

                Webcam.set({
                    width: 300,
                    height: 300,
                    image_format: "jpeg",
                    jpeg_quality: 50
                });

                Webcam.attach("#my_camera");

                setTimeout(() => {
                    const video = document.querySelector("#my_camera video");
                    if (video) {
                        video.classList.add("img-thumbnail", "shadow-lg");
                    }
                }, 300);

            }

            initCamera();


            /* ==============================
               TAKE PHOTO
            ============================== */
            window.take_snapshot = function() {

                if (!navigator.geolocation) {
                    alert("Geolocation tidak didukung browser.");
                    return;
                }

                navigator.geolocation.getCurrentPosition(

                    function(position) {

                        latitudeInput.value = parseFloat(position.coords.latitude);
                        longitudeInput.value = parseFloat(position.coords.longitude);

                        Webcam.snap(function(data_uri) {

                            photoInput.value = data_uri;

                            result.innerHTML =
                                `<img class="img-thumbnail shadow-lg" src="${data_uri}" />`;

                            Webcam.reset();

                            /* sembunyikan kamera */
                            cameraWrapper.style.display = "none";
                            scanner.style.display = "none";

                            takeButton.style.display = "none";
                            retakeButton.style.display = "inline-block";

                            if (submitButton) {
                                submitButton.style.display = "inline-block";
                            }

                        });

                    },

                    function(error) {
                        alert("Gagal mendapatkan lokasi: " + error.message);
                    },

                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }

                );

            };


            /* ==============================
               RETAKE PHOTO
            ============================== */
            window.retake = function() {

                cameraWrapper.style.display = "block";
                scanner.style.display = "block";

                initCamera();

                retakeButton.style.display = "none";
                takeButton.style.display = "inline-block";

                if (submitButton) {
                    submitButton.style.display = "none";
                }

                result.innerHTML = "Silahkan ambil foto absen terlebih dahulu...";

                photoInput.value = "";
                latitudeInput.value = "";
                longitudeInput.value = "";

            };


            /* ==============================
               CLOCK
            ============================== */
            function startTime() {

                const today = new Date();

                let h = today.getHours();
                let m = today.getMinutes();
                let s = today.getSeconds();

                h = checkTime(h);
                m = checkTime(m);
                s = checkTime(s);

                const jam = h + ":" + m + ":" + s + " WIB";

                const jamInput = document.getElementById("jam");
                if (jamInput) {
                    jamInput.value = jam;
                }

                setTimeout(startTime, 1000);
            }

            function checkTime(i) {
                return (i < 10) ? "0" + i : i;
            }

            startTime();

        });
    </script>
@endsection

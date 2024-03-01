@extends('layout.base')

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
            <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Absensi</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" autocomplete="off" value="{{ auth()->user()->name }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="">Tipe Absensi</label>
                            <select name="jenis_absensi_id" class="form-control" required>
                                <option value="" selected disabled>- pilih tipe absensi -</option>
                                @foreach ($jenis_absensi as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == 1) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" placeholder="Tanggal Absensi" onfocus="(this.type='date')"
                                onblur="(this.type='text')" class="form-control" name="tanggal" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">Jam</label>
                            <input type="text" placeholder="Jam Masuk" onfocus="(this.type='time')"
                                onblur="(this.type='text')" class="form-control" name="jam" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="">Photo</label>
                            <input type="hidden" class="form-control input-photo" name="photo" id="photo"
                                accept="image/*" required hidden>
                            <div class="text-center">
                                <div class="img-thumbnail mt-2 text-center" id="my_camera"></div>
                                <input type="button" class="btn btn-primary" value="Ambil Foto" onClick="take_snapshot()">
                                <div class="mt-3 text-center">
                                    <div id="result">Your captured image will appear here...</div>
                                </div>
                            </div>
                            <div class="btn group-button">
                                <button type="submit" id="submit" name="submit"
                                    class="btn btn-primary float-right ml-3">Submit</button>
                                <a href="{{ route('absensi.my_index') }}" class="btn btn-dark">Batal</a>
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
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            var camera = document.getElementById('my_camera');
            Webcam.snap(function(data_uri) {
                $(".input-photo").val(data_uri);
                document.getElementById('result').innerHTML = '<img class="img-thumbnail" src="' + data_uri + '"/>';
            });
            Webcam.reset();
            camera.style.display = 'none';
        }
    </script>
@endsection

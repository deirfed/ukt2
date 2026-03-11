@extends('layout.base_user')

@section('title-head')
    <title>
        Absensi | Tambah Data Absensi Piket
    </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('simoja.pjlp.index') }}">Absensi</a></li>
            <li class="breadcrumb-item active">Tambah Data Absensi Piket</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('simoja.pjlp.absensi.piket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-body">
                        <h4 class="text-center"><u>Form Absensi Piket</u></h4>
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
                        <div class="form-group">
                            <label>Informasi:</label>
                            <div class="border rounded p-3" style="background-color: rgb(255, 234, 206)">
                                <table class="mb-0 w-100">
                                    <tr>
                                        <td class="text-center align-top pr-2" style="width:30px;">1.</td>
                                        <td>Setiap personel hanya memiliki jatah piket maksimal <b>4 hari</b> dalam satu bulan.</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-top pr-2">2.</td>
                                        <td>Absensi piket hanya dapat ditambahkan pada <b>bulan yang sedang berjalan</b>.</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-top pr-2">3.</td>
                                        <td>Untuk menghindari bentrok jadwal dengan personel lain, harap melakukan <b>koordinasi terlebih dahulu</b>.</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center align-top pr-2">4.</td>
                                        <td>Tanggal yang tersedia hanya menampilkan hari di mana Anda <b>belum melakukan absensi masuk maupun pulang</b>.
                                        Jika pada tanggal tersebut sudah terdapat absensi (masuk atau pulang), maka tanggal tersebut tidak akan muncul.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jenis Absensi:</label>
                            <input type="text" class="form-control" value="{{ $jenis_absensi->name ?? '#' }}" disabled>
                            <input type="hidden" class="form-control" value="{{ $jenis_absensi->id }}"
                                name="jenis_absensi_id">
                        </div>
                        <div class="form-group">
                            <label>Sisa Jatah Piket ({{ $bulan_full }} {{ $tahun }}):</label>
                            <input type="text" class="form-control" value="{{ $sisa_jatah_piket }} hari" disabled>
                        </div>
                        <div class="form-group">
                            <label class="required">Tanggal:</label>
                            <select class="form-control" name="tanggal" required>
                                <option value="" disabled selected>- pilih tanggal piket yang tersedia -</option>
                                @foreach ($tanggals as $item)
                                    <option value="{{ $item->tanggal }}">
                                        {{ $item->hari }}, {{ $item->tanggal_fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="optional" for="catatan">Catatan:</label>
                            <textarea id="catatan" class="form-control" name="catatan" rows="3"></textarea>
                        </div>
                        <div class="btn group-button mt-2 d-flex justify-content-end">
                            <a href="{{ route('simoja.pjlp.my-absensi') }}" class="btn btn-dark rounded me-3">
                                <i class="fa fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" id="submit" name="submit" class="btn btn-primary rounded ml-3">
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

@endsection

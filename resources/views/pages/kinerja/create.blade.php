@extends('layout.base')

@section('title-head')
    <title>
        Kinerja | Tambah Data Laporan Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Kinerja</li>
            <li class="breadcrumb-item active">Laporan Kinerja</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('kinerja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Laporan Kinerja</div>
                    </div>
                    <input type="text" name="formasi_tim_id" value="{{ $formasi_tim->id }}" hidden>
                    <input type="text" name="anggota_id" value="{{ auth()->user()->id }}" hidden>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Data Lengkap</label>
                            <table>
                                <tr>
                                    <td style="width: 90px">Nama</td>
                                    <td style="width: 15px">:</td>
                                    <td class="font-weight-bolder">{{ auth()->user()->name }}</td>
                                </tr>
                                <tr>
                                    <td>NIP</td>
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
                                    <td>{{ $formasi_tim->koordinator->name }}</td>
                                </tr>
                                <tr>
                                    <td>Tim</td>
                                    <td>:</td>
                                    <td>{{ $formasi_tim->struktur->tim->name }}</td>
                                </tr>
                                <tr>
                                    <td>Seksi</td>
                                    <td>:</td>
                                    <td>{{ $formasi_tim->struktur->seksi->name }}</td>
                                </tr>
                                <tr>
                                    <td>Pulau</td>
                                    <td>:</td>
                                    <td>Pulau {{ $formasi_tim->area->pulau->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <select id="kategori_id" name="kategori_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama kegiatan -</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                                <option value="">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group" id="kegiatan_lainnya_container" style="display: none">
                            <label>Kegiatan Lainnya</label>
                            <input type="text" id="kegiatan_lainnya" class="form-control" name="kegiatan"
                                placeholder="input nama kegiatan lainnya" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Lokasi Kegiatan</label>
                            <input type="text" class="form-control" name="lokasi" placeholder="input lokasi kegiatan"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                class="form-control" name="tanggal" placeholder="input tanggal kegiatan" required
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="">Photo Kegiatan</label>
                            <input type="file" class="form-control image-input" name="photo[]" multiple accept="image/*"
                                required>
                            @error('photo')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <div class="row-group d-flex preview-container my-2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan <span class="text-success">(opsional)</span></label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('kinerja.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var kategori = document.getElementById('kategori_id');
        var inputKegiatanLainnya = document.getElementById('kegiatan_lainnya');
        var containerKegiatanLainnya = document.getElementById('kegiatan_lainnya_container');

        kategori.addEventListener('change', function() {
            if (kategori.value === '') {
                kategori.required = false;
                containerKegiatanLainnya.style.display = 'block';
                inputKegiatanLainnya.required = true;
            } else {
                containerKegiatanLainnya.style.display = 'none';
                inputKegiatanLainnya.required = false;
            }
        });

        const imageInputs = document.querySelectorAll('.image-input');
        const previewContainer = document.querySelector('.preview-container');

        imageInputs.forEach(input => {
            input.addEventListener('change', function(event) {
                previewContainer.innerHTML = '';

                const files = event.target.files;
                for (const file of files) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewImage = document.createElement('img');
                        previewImage.className = 'preview-image';
                        previewImage.src = e.target.result;
                        previewImage.style = 'width: 80px;';
                        previewImage.className = 'img-thumbnail btn-group mt-2 me-2 d-inline-flex';

                        previewContainer.appendChild(previewImage);
                    }

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection

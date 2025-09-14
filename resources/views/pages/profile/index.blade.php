@extends('layout.base_user')

@section('title-head')
    <title>
        User Profil
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Profil</li>
            <li class="breadcrumb-item active">User Profil</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="user-details h-320">
                <a href="javascript:;" data-toggle="modal" data-target="#formPhotoProfilModal">
                    <div class="user-thumb">
                        <img src="{{ auth()->user()->photo != null ? asset('storage/' . auth()->user()->photo) : 'https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg' }}"
                            alt="Photo">
                    </div>
                </a>
                <h4>{{ auth()->user()->name }}</h4>
                <h5>{{ auth()->user()->nip }}</h5>
                <br>
                <h5>Seksi {{ auth()->user()->struktur->seksi->name }}</h5>
                <p>Pulau {{ auth()->user()->area->pulau->name }}</p>
                <h5>Sisa Cuti Anda: {{ $sisa_cuti }} </h5>
            </div>
        </div>
        <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="name" placeholder="Nama"
                                    value={{ auth()->user()->name }} readonly>

                            </div>
                            <div class="form-group">
                                <label for="eMail">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                    value={{ auth()->user()->email }} disabled>
                            </div>
                            <div class="form-group">
                                <label for="phone">Nomer HP</label>
                                <input type="text" class="form-control" id="no_hp" placeholder="Nomer HP"
                                    value="{{ auth()->user()->phone }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="seksi">Seksi</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Seksi"
                                    value="{{ auth()->user()->struktur->seksi->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="ciTy">Jabatan</label>
                                <input type="koordinator" class="form-control" id="pulau" placeholder="Koordinator"
                                    value="{{ auth()->user()->jabatan->name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="pulau">Tempat Bertugas</label>
                                <input type="text" class="form-control" id="pulau" placeholder="Pulau"
                                    value="Pulau {{ auth()->user()->area->pulau->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="text-right">
                                <button type="button" id="submit" name="submit" class="btn btn-primary">Simpan
                                    Perubahan</button>
                                <a href="{{ route('user.profile.edit.password') }}" class="btn btn-warning">Ubah
                                    Password</a>
                                <a href="{{ route('dashboard.index') }}" class="btn btn-danger">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">📄 Daftar Surat Peringatan (SP) - Tahun {{ $tahun }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table([
                            'class' => 'table table-bordered table-striped',
                        ]) }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- BEGIN: Update Photo Profil --}}
    <div id="formPhotoProfilModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Photo Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img class="img-thumbnail" id="previewImage" src="#" alt="Preview"
                            style="max-width: 250px; max-height: 250px; display: none;">
                    </div>
                    <div class="form-row gutters mt-3">
                        <form action="{{ route('user.update_photo') }}" id="formPhotoProfil" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="">Photo Profil</label>
                                <input type="file" id="imageInput" name="photo" class="form-control"
                                    accept="image/*" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submut" form="formPhotoProfil" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Update Photo Profil --}}

    {{-- BEGIN: Update Photo TTD --}}
    <div id="formPhotoTTDModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Photo TTD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img class="img-thumbnail" id="previewImageTTD" src="#" alt="Preview"
                            style="max-width: 250px; max-height: 250px; display: none;">
                    </div>
                    <div class="form-row gutters mt-3">
                        <form action="{{ route('user.update_ttd') }}" id="formPhotoTTD" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="">Photo TTD</label>
                                <input type="file" id="imageInputTTD" name="photo" class="form-control"
                                    accept="image/*" required>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submut" form="formPhotoTTD" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END: Update Photo TTD --}}
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('javascript')
    <script>
        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                }

                reader.readAsDataURL(selectedFile);
            }
        });

        const imageInputTTD = document.getElementById('imageInputTTD');
        const previewImageTTD = document.getElementById('previewImageTTD');

        imageInputTTD.addEventListener('change', function(event) {
            const selectedFile = event.target.files[0];

            if (selectedFile) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImageTTD.src = e.target.result;
                    previewImageTTD.style.display = 'block';
                }

                reader.readAsDataURL(selectedFile);
            }
        });
    </script>
@endsection

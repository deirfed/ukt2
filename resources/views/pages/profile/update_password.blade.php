@extends('layout.base_user')

@section('title-head')
    <title>
        User Profil | Ubah Password
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
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('user.profile.update.password') }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-body">
                        <h4 class="text-center"><u>Form Ubah Password</u></h4>
                        <div class="form-group">
                            <label for="old_password">Password Lama</label>
                            <input type="password" id="old_password" name="old_password" class="form-control"
                                placeholder="input password lama" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" id="new_password" name="new_password" class="form-control"
                                placeholder="input password baru" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="confirm_new_password">Konfirmasi Password Baru</label>
                            <input type="password" id="confirm_new_password" name="confirm_new_password"
                                class="form-control" placeholder="input konfirmasi password baru" required
                                autocomplete="off">
                        </div>
                        <div class="btn group-button mt-2">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('user.profile') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
@endsection

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

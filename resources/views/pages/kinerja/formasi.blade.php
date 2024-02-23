@extends('layout.base')

@section('title-head')
    <title>
        Kinerja | Formasi Personel
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Kinerja</li>
            <li class="breadcrumb-item">Formasi Personel</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pencahayaan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Tim Abdul Kohar Mudzakir</h4>
                                <h5>Seksi Pencahayaan I</h5>
                                <p>Pulau Tidung</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar
                                    Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pertamanan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Tim Joko Driyono Putra Harefa</h4>
                                <h5>Seksi Pertamanan I</h5>
                                <p>Pulau Karya</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pertamanan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Tim Rocky Gerung</h4>
                                <h5>Seksi Pertamanan II</h5>
                                <p>Pulau Panggang</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pertamanan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Tim La Nyalla Martadinata</h4>
                                <h5>Seksi Pertamanan III</h5>
                                <p>Pulau Sebira</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pencahayaan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Tim Lucky Ariowibowo</h4>
                                <h5>Seksi Pencahayaan II</h5>
                                <p>Pulau Pramuka</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pencahayaan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Tim Jono Purowoto</h4>
                                <h5>Seksi Pencahayaan III</h5>
                                <p>Pulau Pari</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar Personel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade detailPersonel" tabindex="-1" role="dialog" aria-labelledby="detailPersonel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPersonel">Daftar Personel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row-modal-user gutters">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="formasi-modal">
                                <div class="user-card">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                    <h5>Muhammad Pikri</h5>
                                </div>
                                <div class="user-card">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                    <h5>Ahmad Jajuli</h5>
                                </div>
                                <div class="user-card">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                    <h5>Pukimak Putra</h5>
                                </div>
                                <div class="user-card">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                    <h5>Henceutalia Putri</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }
    </script>
@endsection
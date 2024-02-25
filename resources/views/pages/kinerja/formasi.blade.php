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
                        @foreach ($formasi_tim as $formasi)
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="tim-formasi h-320" id="tim-formasi-{{ $formasi['seksi'] }}">
                                    <div class="user-thumb">
                                        <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                            alt="Admin Template" />
                                    </div>
                                    <h3>{{ $formasi['koordinator']->name }}</h3>
                                    <h4>{{ $formasi['tim'] }}</h4>
                                    <h5>{{ $formasi['seksi'] }}</h5>
                                    <p>{{ $formasi['pulau'] }}</p>
                                    <button class="btn btn-light tampilkan-anggota" data-toggle="modal"
                                        data-target="#ModalDetail" data-anggota="{{ $formasi['anggota'] }}">
                                        Lihat Daftar Personel
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pertamanan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Koord. Joko Driyono Putra Harefa</h4>
                                <h5>Seksi Pertamanan I</h5>
                                <p>Pulau Karya</p>
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
                                <h4>Koord. Rocky Gerung</h4>
                                <h5>Seksi Pertamanan II</h5>
                                <p>Pulau Panggang</p>
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
                                <h4>Koord. La Nyalla Martadinata</h4>
                                <h5>Seksi Pertamanan III</h5>
                                <p>Pulau Sebira</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar
                                    Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pencahayaan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Koord. Lucky Ariowibowo</h4>
                                <h5>Seksi Pencahayaan II</h5>
                                <p>Pulau Pramuka</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar
                                    Personel</button>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="tim-formasi-pencahayaan h-320">
                                <div class="user-thumb">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Admin Template" />
                                </div>
                                <h4>Koord. Jono Purowoto</h4>
                                <h5>Seksi Pencahayaan III</h5>
                                <p>Pulau Pari</p>
                                <button class="btn btn-light" data-toggle="modal" data-target=".detailPersonel">Lihat Daftar
                                    Personel</button>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade detailPersonel" id="ModalDetail" tabindex="-1" role="dialog" aria-labelledby="detailPersonel"
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
                            <div class="formasi-modal" id="anggotaModalBody">
                                {{-- <div class="user-card">
                                    <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                        alt="Photo" />
                                    <h5>Muhammad Pikri</h5>
                                </div> --}}
                                {{-- <div class="user-card">
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
                                </div> --}}
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


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var formasiTimElements = document.querySelectorAll('.tim-formasi');

            formasiTimElements.forEach(function(element) {
                var seksi = element.querySelector('h5').innerText;

                if (seksi.includes('Pencahayaan')) {
                    element.classList.add('tim-formasi-pencahayaan');
                } else if (seksi.includes('Pertamanan')) {
                    element.classList.add('tim-formasi-pertamanan');
                }
            });
        });
    </script>
@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#ModalDetail').on('show.bs.modal', function(e) {
                var anggota = $(e.relatedTarget).data('anggota');
                var modalBody = $('#anggotaModalBody');
                modalBody.empty(); // Kosongkan konten modal sebelumnya
                anggota.forEach(function(item) {
                    var photo = item.photo ? asset('/storage' + item.photo) :
                        'https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg';

                    var userCard = '<div class="user-card">' +
                        '<img src="' + photo + '" alt="Photo" />' +
                        '<h5>' + item.name + '</h5>' +
                        '</div>';

                    modalBody.append(userCard);
                });
            });
        });
    </script>
@endsection

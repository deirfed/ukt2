@extends('layout.base')

@section('title-head')
    <title>
        Manajemen Asset | Gudang
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Manajemen Asset</li>
            <li class="breadcrumb-item active">Gudang</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="chat-section">
                <!-- Row start -->
                <div class="row no-gutters">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-2 col-3">
                        <div class="users-container">
                            <div class="chat-search-box">
                                <div class="input-group">
                                    <input class="form-control" placeholder="Search" id="search-bar-2" />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-primary">
                                            <i class="icon-magnifying-glass"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="usersContainerScroll" id="dataTable-2">
                                <ul class="users">
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder" style="font-size: 20px">Gudang Utama</span>
                                            <span class="time">Admin: Wibih Abdi</span>
                                        </p>
                                    </li>
                                    {{-- DUMMY --}}
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Untung Jawa</span>
                                            <span class="time">Koordinator: Ahmad Saputra</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Tidung</span>
                                            <span class="time">Koordinator: Memek Kameludin</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Karya</span>
                                            <span class="time">Koordinator: Joko</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Pramuka</span>
                                            <span class="time">Koordinator: Roro Kameludin</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Lancang</span>
                                            <span class="time">Koordinator: Hawasyi Akbar</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Sebira</span>
                                            <span class="time">Koordinator: Alvin Mubarok</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Panggang</span>
                                            <span class="time">Koordinator: Rudi Hadi</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Kelapa</span>
                                            <span class="time">Koordinator: Koko</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Kelapa Dua</span>
                                            <span class="time">Koordinator: Popon Kerok</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Payung</span>
                                            <span class="time">Koordinator: Riki Shimitzu</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Pari</span>
                                            <span class="time">Koordinator: Ihsan Kamaludin</span>
                                        </p>
                                    </li>
                                    <li class="person">
                                        <div class="user">
                                            <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                                alt="Profile" />
                                            <span class="status online"></span>
                                        </div>
                                        <p class="name-time">
                                            <span class="name font-bolder">Gudang Pulau Tidung</span>
                                            <span class="time">Koordinator: Boris Bokir</span>
                                        </p>
                                    </li>
                                    {{-- END DUMMY --}}
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-9 col-md-8 col-sm-10 col-9">
                        <div class="active-user-chatting">
                            <div class="active-user-info">
                                <img src="https://img.freepik.com/free-psd/3d-illustration-human-avatar-profile_23-2150671142.jpg"
                                    class="avatar" alt="avatar" />
                                <div class="avatar-info">
                                    <h5 class="mb-2">Gudang Utama</h5>
                                    <span class="time">Admin: Wibih Abdi</span>
                                </div>
                                <div class="btn-group ml-3">
                                    <button type="button" class="btn btn-lg btn-primary">Pilih Pengadaan</button>
                                    <button type="button"
                                        class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">S.50938/DKI</a>
                                        <a class="dropdown-item" href="#">S.47829/DKI</a>
                                        <a class="dropdown-item" href="#">S.39484/DKI</a>
                                    </div>
                                </div>
                                <div class="btn-group ml-3">
                                    <button type="button" class="btn btn-lg btn-primary">Log Distribusi</button>
                                    <button type="button"
                                        class="btn btn-lg btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">S.50938/DKI</a>
                                        <a class="dropdown-item" href="#">S.47829/DKI</a>
                                        <a class="dropdown-item" href="#">S.39484/DKI</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-container">
                            <div class="materialContainerScroll">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Nama Barang</th>
                                                <th class="text-center">Merk Barang</th>
                                                <th class="text-center">Stock Awal</th>
                                                <th class="text-center">Stock Saat Ini</th>
                                                <th class="text-center">Satuan</th>
                                                <th class="text-center">Spesifikasi</th>
                                                <th class="text-center">Dokumentasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2</td>
                                                <td class="text-center">Paralon</td>
                                                <td class="text-center">Pralon 4"</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">3</td>
                                                <td class="text-center">Kabel NYA</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">4</td>
                                                <td class="text-center">Semen</td>
                                                <td class="text-center">Tiga Roda</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">5</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">6</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">7</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">8</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">9</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">10</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">11</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jakari</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">12</td>
                                                <td class="text-center">Kabel NYM</td>
                                                <td class="text-center">Jembo</td>
                                                <td class="text-center">1203</td>
                                                <td class="text-center">900</td>
                                                <td class="text-center">Roll</td>
                                                <td class="text-center">Kabel NYM 1.2mm KSHY 12A</td>
                                                <td class="text-center">
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-edit"></i></button></a>
                                                    <a href="#"><button class="btn btn-outline-primary"><i
                                                                class="fa fa-eye" data-toggle="modal"
                                                                data-target="#modalLampiran"></i></button></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="chat-form">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Cari Barang" id="search-bar"></input>
                                    <button class="btn btn-primary">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade logDistribusi" tabindex="-1" role="dialog" aria-labelledby="logDistribusi"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDistribusi">Log Distribusi Gudang Utama</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

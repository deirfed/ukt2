@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | User List
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Daftar User</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group">
                <a class="btn btn-outline-primary mb-3" href="{{ route('data_essentials.index') }}">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
                <a class="btn btn-primary mb-3" href="{{ route('user.create') }}">
                    Tambah Data
                </a>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h4 class="mb-2">Daftar User PNS</h4>
                        <form class="form-inline mb-2">
                            <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                aria-label="Search" id="search-bar">
                            <button class="btn btn-primary my-2 my-sm-0" type="submit">Pencarian</button>
                        </form>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-primary" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama </th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users_organik as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->name }}</td>
                                            <td class="text-center">{{ $item->email }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-dark" data-toggle="modal"
                                                    data-target="#exampleModalCenter"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <h4 class="mb-2">Daftar User PJLP</h4>
                        <form class="form-inline mb-2">
                            <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                aria-label="Search" id="search-bar-2">
                            <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                        </form>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-dark" id="dataTable-2">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kode Email</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users_organik as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->name }}</td>
                                            <td class="text-center">{{ $item->email }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#exampleModalCenter"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

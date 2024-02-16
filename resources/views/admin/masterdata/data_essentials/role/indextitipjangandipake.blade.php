@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Manajemen Role
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Manajemen Role</li>
            <li class="breadcrumb-item active">Daftar Role</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div>
                <a href="{{ route('role.create') }}"><button class="btn btn-primary mb-3">Tambah Data</button></a>
            </div>
        </div>
    </div>
    <div class="row gutters">
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4>MRT Jakarta's User</h4>
                    <form class="form-inline mx-auto my-2 my-lg-0 mb-10">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-dark m-0" class="dataTables_filter">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Section</th>
                                    <th class="text-center">Contact</th>
                                    <th class="text-center">Position</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Dede Irfan</td>
                                    <td class="text-center">PWRAMS</td>
                                    <td class="text-center">0801</td>
                                    <td class="text-center">aliawilllams@wafi.com</td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-primary" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-outline-primary"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h4>Third Party's Users</h4>
                    <form class="form-inline mx-auto my-2 my-lg-0 mb-10">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-primary m-0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Section</th>
                                    <th class="text-center">Contact</th>
                                    <th class="text-center">Position</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">Dede Irfan</td>
                                    <td class="text-center">PWRAMS</td>
                                    <td class="text-center">0801</td>
                                    <td class="text-center">aliawilllams@wafi.com</td>
                                    <td class="text-center">
                                        <button class="btn btn-outline-dark" data-toggle="modal"
                                            data-target="#exampleModalCenter"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-outline-dark"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

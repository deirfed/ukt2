@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Section List
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Section</li>
            <li class="breadcrumb-item active">Section List</li>
        </ol>
    </div>
@endsection


@section('content')
<div class="row gutters">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        <a href="{{ route('masterdata-section.create') }}"><button class="btn btn-primary mb-3">Add Data</button></a>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Section Name</th>
                                <th class="text-center">Section Code</th>
                                <th class="text-center">Departement</th>
                                <th class="text-center">Division</th>
                                <th class="text-center">Directory</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">Permanent Way RAMS</td>
                                <td class="text-center">PW RAMS</td>
                                <td class="text-center">Civil Permanent Way Maintenance Technology Departement</td>
                                <td class="text-center">Railway Infrastructure Maintenance Division</td>
                                <td class="text-center">Operational & Maintenance Directory</td>
                                <td class="text-center">PT. MRT Jakarta</td>
                                <td class="text-center">
                                    <a href=""><button class="btn btn-outline-primary"><i class="fa fa-edit"></i></button></a>
                                    <a href=""><button class="btn btn-outline-primary"><i class="fa fa-trash"></i></button></a>
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

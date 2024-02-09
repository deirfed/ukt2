@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Department List
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Department</li>
            <li class="breadcrumb-item active">Department List</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('masterdata-department.create') }}"><button class="btn btn-primary mb-3">Add
                                    Data</button></a>
                            <form class="form-inline ">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                                    id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Department Name</th>
                                    <th class="text-center">Department Code</th>
                                    <th class="text-center">Division</th>
                                    <th class="text-center">Directory</th>
                                    <th class="text-center">Company</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->code }}</td>
                                        <td class="text-center">{{ $item->division->name }}</td>
                                        <td class="text-center">{{ $item->directory->name }}</td>
                                        <td class="text-center">{{ $item->company->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('masterdata-department.show', $item->uuid) }}"><button
                                                    class="btn btn-outline-primary"><i class="fa fa-edit"></i></button></a>
                                            <a href="#" href="javascript:;" data-toggle="modal"
                                                data-target="#delete-confirmation-modal"
                                                onclick="toggleModal('{{ $item->id }}')"><button
                                                    class="btn btn-outline-primary"><i class="fa fa-trash"></i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-2">
                    <div class="p-2 text-center">
                        <div class="text-3xl mt-2">Are you sure?</div>
                        <div class="text-slate-500 mt-2">Warning: This data will be deleted permanently</div>
                    </div>
                    <div class="px-5 pb-8 text-center mt-3">
                        <form action="{{ route('masterdata-department.destroy') }}" method="POST">
                            @csrf
                            @method('delete')
                            <input type="text" name="id" id="id" hidden>
                            <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Cancel</button>
                            <button type="submit" class="btn btn-primary w-24">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
@endsection

@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }
    </script>
@endsection

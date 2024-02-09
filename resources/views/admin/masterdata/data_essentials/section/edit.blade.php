@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Edit Department
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Department</li>
            <li class="breadcrumb-item active">Edit Data Department</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('masterdata-department.update', $department->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Edit Department</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Department Name</label>
                            <input type="text" hidden value="{{ $department->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $department->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Department Code</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $department->code }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Division</label>
                            <select class="form-control selectpicker" name="division_id">
                                <option disabled value="" selected> - Choose Division - </option>
                                @foreach ($division as $item)
                                    <option value="{{ $item->id }}" @if ($department->division_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Directory</label>
                            <select class="form-control selectpicker" name="directory_id">
                                <option disabled value="" selected> - Choose Directory - </option>
                                @foreach ($directory as $item)
                                    <option value="{{ $item->id }}" @if ($department->directory_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Company</label>
                            <select class="form-control selectpicker" name="company_id">
                                <option disabled value="" selected> - Choose Company - </option>
                                @foreach ($company as $item)
                                    <option value="{{ $item->id }}" @if ($department->company_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Update Data</button>
                            <a href="{{ route('masterdata-department.index') }}" class="btn btn-dark">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Edit Directory
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Directory</li>
            <li class="breadcrumb-item active">Edit Data Directory</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('masterdata-directory.update', $directory->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Edit Directory</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Directory Name</label>
                            <input type="text" hidden value="{{ $directory->id }}" name="id">
                            <input type="text" class="form-control" name="name" autocomplete="off"
                                value="{{ $directory->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Directory Code</label>
                            <input type="text" class="form-control" name="code" autocomplete="off"
                                value="{{ $directory->code }}" required>
                        </div>
                        <div class="form-group">
                            <label for="">Company</label>
                            <select class="form-control selectpicker" name="company_id">
                                <option disabled value="" selected> - Choose Company - </option>
                                @foreach ($company as $item)
                                    <option value="{{ $item->id }}" @if ($directory->company_id == $item->id) selected @endif>{{ $item->name }} ({{ $item->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Update Data</button>
                            <a href="{{ route('masterdata-directory.index') }}" class="btn btn-dark">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

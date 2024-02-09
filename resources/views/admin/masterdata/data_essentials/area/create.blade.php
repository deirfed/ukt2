@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Add Area
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Area</li>
            <li class="breadcrumb-item active">Add Area</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form>
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Add Shift</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="shift_name" name="shift_name"
                                placeholder="Area Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="shift_code" name="shift_code"
                                placeholder="Area Code" required="">
                        </div>
                        <button type="button" id="submit" name="submit"
                            class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Add Shift
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Shift</li>
            <li class="breadcrumb-item active">Add Shift</li>
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
                                placeholder="Shift Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="shift_code" name="shift_code"
                                placeholder="Shift Code" required="">
                        </div>
                        <div class="form-group">
                            <p>Shift Start</p>
                            <input type="time" class="form-control" id="shift_start" name="shift_start"
                                placeholder="Shift Start" required="">
                        </div>
                        <div class="form-group">
                            <p>Shift End</p>
                            <input type="time" class="form-control" id="shift_end" name="shift_end"
                                placeholder="Shift End" required="">
                        </div>
                        <button type="button" id="submit" name="submit"
                            class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Add Line
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Line</li>
            <li class="breadcrumb-item active">Add Line</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form>
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Add Line</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="line_name" name="line_name"
                                placeholder="Line Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="line_code" name="line_code"
                                placeholder="Line Code" required="">
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Area - </option>
                                <option>Mainline</option>
                            </select>
                        </div>
                        <button type="button" id="submit" name="submit"
                            class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

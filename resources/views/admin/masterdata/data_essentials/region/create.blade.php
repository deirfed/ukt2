@extends('layout.base')

@section('title-head')
<title>
    Master Data | Add Region
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Region</li>
            <li class="breadcrumb-item active">Add Region</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form>
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Add Region</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="region_name" name="region_name"
                                placeholder="Region Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="region_code" name="region_code"
                                placeholder="Region Code" required="">
                        </div>
                        <button type="button" id="submit" name="submit"
                            class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

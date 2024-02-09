@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Add Location
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Location</li>
            <li class="breadcrumb-item active">Add Location</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form>
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Add Location</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="location_name" name="location_name"
                                placeholder="Location Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="location_code" name="location_code"
                                placeholder="Location Code" required="">
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Area - </option>
                                <option>Mainline</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Region - </option>
                                <option>Region 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> Apakah ini Stasiun? </option>
                                <option>Ya</option>
                                <option>Tidak</option>
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

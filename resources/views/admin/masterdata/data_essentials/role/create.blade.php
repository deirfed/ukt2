@extends('layout.base')

@section('title-head')
<title>
    Masterdata | Add Role
</title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Managamenet Role</li>
            <li class="breadcrumb-item active">Add Role</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form>
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Add Role</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="section_name" name="section_name"
                                placeholder="Directory Name" required="">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="section_code" name="section_code"
                                placeholder="Directory Code" required="">
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Departement - </option>
                                <option>Civil Permanent Way Maintenance Technology Departement</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Division - </option>
                                <option>Railway Infrastructure Maintenance Division</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Directory - </option>
                                <option>Operational & Maintenance Directory</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker">
                                <option selected> - Choose Company - </option>
                                <option>PT. MRT Jakarta</option>
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

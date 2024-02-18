@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Relasi Role
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Manajemen Role</li>
            <li class="breadcrumb-item active">Ubah Data Relasi Role</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('role_user.update', $role_user->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Edit Role</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Nama User</label>
                            <input type="text" class="form-control" autocomplete="off"
                                value="{{ $role_user->user->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <select name="role_id" class="form-control" required>
                                <option value="" selected disabled>- pilih role -</option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $role_user->role->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah Data</button>
                            <a href="{{ route('role.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Superadmin | Ubah Data Users
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item active">Ubah Data User</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data User</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Lengkap" value="{{ $user->name }}" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}"
                                name="email" placeholder="Email" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP"
                                value="{{ $user->nip }}" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="No HP"
                                required autocomplete="off" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="gender" required>
                                <option value="" selected disabled> - jenis kelamin - </option>
                                <option value="Bapak" @if ($user->gender == 'Bapak') selected @endif>Laki-laki</option>
                                <option value="Ibu" @if ($user->gender == 'Ibu') selected @endif>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                placeholder="Tempat Lahir" value="{{ $user->tempat_lahir }}" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                placeholder="Tanggal Lahir" onfocus="(this.type='date')" onblur="(this.type='text')"
                                required value="{{ $user->tanggal_lahir }}">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                placeholder="Alamat Lengkap" value="{{ $user->alamat }}" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="role_id" required>
                                <option value="" selected disabled> - pilih role - </option>
                                @foreach ($role as $item)
                                    <option value="{{ $item->id }}" @if ($user->role_id == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="jabatan_id" required>
                                <option value="" selected disabled> - pilih jabatan - </option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}" @if ($user->jabatan_id == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="employee_type_id" required>
                                <option value="" selected disabled> - pilih employee type - </option>
                                @foreach ($employee_type as $item)
                                    <option value="{{ $item->id }}" @if ($user->employee_type_id == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="area_id" required>
                                <option value="" selected disabled> - pilih area - </option>
                                @foreach ($area as $item)
                                    <option value="{{ $item->id }}" @if ($user->area_id == $item->id) selected @endif>
                                        {{ $item->pulau->name }} -
                                        Kelurahan {{ $item->kelurahan->name }} - Pulau {{ $item->kecamatan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control selectpicker" name="struktur_id" required>
                                <option value="" selected disabled> - pilih seksi - </option>
                                @foreach ($struktur as $item)
                                    <option value="{{ $item->id }}" @if ($user->struktur_id == $item->id) selected @endif>
                                        {{ $item->seksi->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Submit</button>
                            <a href="{{ route('user.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

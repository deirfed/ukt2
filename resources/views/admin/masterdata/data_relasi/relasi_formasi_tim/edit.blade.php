@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Ubah Data Relasi Formasi Tim
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Relasi</li>
            <li class="breadcrumb-item">Formasi Tim</li>
            <li class="breadcrumb-item active">Ubah Data Relasi Formasi Tim</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters justify-content-center">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
            <form action="{{ route('formasi_tim.update', $formasi_tim->uuid) }}" method="POST">
                @csrf
                @method('put')
                <div class="card m-0">
                    <div class="card-header">
                        <div class="card-title">Form Ubah Data Formasi Tim</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Periode</label>
                            <input type="text" class="form-control" name="periode" value="{{ $formasi_tim->periode }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Tim</label>
                            <select name="struktur_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama tim -</option>
                                @foreach ($struktur as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $formasi_tim->struktur->id) selected @endif>
                                        {{ $item->tim->name }} ({{ $item->seksi->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pulau</label>
                            <select name="area_id" class="form-control" required>
                                <option value="" selected disabled>- pilih nama pulau -</option>
                                @foreach ($area as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $formasi_tim->area->id) selected @endif>
                                        {{ $item->pulau->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Koordinator</label>
                            <select name="koordinator_id" class="form-control" required>
                                <option value="" selected disabled>- pilih koordinator -</option>
                                @foreach ($koordinator as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $formasi_tim->koordinator->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Anggota</label>
                            <select name="anggota_id" class="form-control" required>
                                <option value="" selected disabled>- pilih anggota -</option>
                                @foreach ($anggota as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == $formasi_tim->anggota->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn group-button">
                            <button type="submit" id="submit" name="submit"
                                class="btn btn-primary float-right ml-3">Ubah</button>
                            <a href="{{ route('formasi_tim.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

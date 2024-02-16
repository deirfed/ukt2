@extends('layout.base')

@section('title-head')
    <title>
        Masterdata | Daftar Unit Kerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item">Data Essentials</li>
            <li class="breadcrumb-item">Unit Kerja</li>
            <li class="breadcrumb-item active">Daftar Unit Kerja</li>
        </ol>
    </div>
@endsection


@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <a href="{{ route('unitkerja.create') }}"><button class="btn btn-primary mb-3">Add Data</button></a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Nama Unit Kerja</th>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Walikota/Kabupaten</th>
                                    <th class="text-center">Provinsi</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $unitkerja as $item )
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->code }}</td>
                                    <td class="text-center">{{ $item->walikota->name }} ({{ $item->walikota->code }})</td>
                                    <td class="text-center">{{ $item->provinsi->name }} ({{ $item->provinsi->code }})</td>
                                    <td class="text-center">
                                        <a href="{{ route('unitkerja.show', $item->uuid) }}"><button
                                            class="btn btn-outline-primary"><i class="fa fa-edit"></i></button></a>
                                    <a href="#" href="javascript:;" data-toggle="modal"
                                        data-target="#delete-confirmation-modal"
                                        onclick="toggleModal('{{ $item->id }}')"><button
                                            class="btn btn-outline-primary"><i class="fa fa-trash"></i></button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- BEGIN: Delete Confirmation Modal -->
        <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-2">
                        <div class="p-2 text-center">
                            <div class="text-3xl mt-2">Apakah anda yakin?</div>
                            <div class="text-slate-500 mt-2">Peringatan: Data ini akan dihapus secara permanent</div>
                        </div>
                        <div class="px-5 pb-8 text-center mt-3">
                            <form action="{{ route('unitkerja.destroy') }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="text" name="id" id="id" hidden>
                                <button type="button" data-dismiss="modal" class="btn btn-dark w-24 mr-1 me-2">Batal</button>
                                <button type="submit" class="btn btn-primary w-24">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
@endsection
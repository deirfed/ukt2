@extends('superadmin.layout.base')

@section('title-head')
    <title>
        Superadmin | Data Users
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Masterdata</li>
            <li class="breadcrumb-item active">Daftar User</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <br>
                            <form class="form-inline mb-2">
                                <input class="form-control mr-sm-2" type="search" placeholder="Cari sesuatu di sini..."
                                    aria-label="Search" id="search-bar">
                                <button class="btn btn-dark my-2 my-sm-0" type="submit">Pencarian</button>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary"><i
                                    class="fa fa-arrow-left"></i>Kembali</a>
                            <a href="{{ route('admin-user.create') }}" class="btn btn-primary">Tambah
                                Data</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped" id="dataTable" name="pns">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Nama </th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Status User</th>
                                        <th class="text-center">Aksi</th>
                                        <th class="text-center">Surat Teguran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->name }}</td>
                                            <td class="text-center">{{ $item->email }}</td>
                                            <td class="text-center">{{ $item->jabatan->name }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">Active</span> / <span
                                                    class="badge badge-danger">Banned</span>
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('admin-user.show', $item->uuid) }}"><button
                                                        class="btn btn-primary"><i class="fa fa-eye"></i></button></a>
                                                <button class="btn btn-outline-danger" data-toggle="modal" data-target="#banUser"
                                                    data-username="{{ $item->name }}" data-userid="{{ $item->id }}">
                                                    <i class="fa fa-ban"></i>
                                                </button>
                                                <button class="btn btn-warning" data-toggle="modal"
                                                    data-target="#resetPasswordModal" data-username="{{ $item->name }}"
                                                    data-userid="{{ $item->id }}">
                                                    <i class="fa fa-asterisk text-white"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $dummyWarnings = rand(0, 3);
                                                @endphp

                                                @for ($i = 1; $i <= 3; $i++)
                                                    <span class="d-inline-block rounded-circle me-1"
                                                        style="width: 18px; height: 18px; background-color: {{ $dummyWarnings >= $i ? '#dc3545' : '#6c757d' }};"
                                                        role="button" data-toggle="modal" data-target="#uploadSuratModal"
                                                        data-username="{{ $item->name }}"
                                                        data-userid="{{ $item->id }}"
                                                        data-warnings="{{ $dummyWarnings }}">
                                                    </span>
                                                @endfor
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
                        <form action="{{ route('admin-user.destroy') }}" method="POST">
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

    {{-- RESET PASSWORD --}}
    {{-- DUMMY --}}
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Konfirmasi Reset Password</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah Anda yakin ingin mereset password user <strong id="modalUsername">user</strong>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" id="btnConfirmReset">Ya, Reset</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DUMMY --}}
    <div class="modal fade" id="resetResultModal" tabindex="-1" role="dialog" aria-labelledby="resetResultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="resetResultModalLabel">Berhasil</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Password user <strong id="resultUsername">user</strong> berhasil diubah ke <code>user123</code>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- BAN USER --}}
    {{-- DUMMY --}}
    <div class="modal fade" id="banUser" tabindex="-1" role="dialog" aria-labelledby="banUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="banUserModalLabel">Konfirmasi Ban User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah Anda yakin ingin menghapus akses user <strong id="modalBanUsername">user</strong>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmBan">Ya, Ban User</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DUMMY --}}
    <div class="modal fade" id="banResultModal" tabindex="-1" role="dialog" aria-labelledby="banResultModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="banResultModalLabel">Berhasil</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    User <strong id="resultBanUsername">user</strong> berhasil diBanned!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- UPLOAD SP --}}
    <div class="modal fade" id="uploadSuratModal" tabindex="-1" aria-labelledby="uploadSuratModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Teguran</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="modalUserId">
                        <div class="mb-3">
                            <label for="file" class="form-label">Nama PJLP:</label><br>
                            <strong id="SPUsername">user</strong>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File:</label>
                            <input type="file" class="form-control" name="file" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Jumlah Surat Peringatan Personel:</label><br>
                            <strong id="jumlahwarnings">0</strong> Surat
                            Teguran
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }

        document.addEventListener("DOMContentLoaded", function() {
            $('#resetPasswordModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');

                document.getElementById("modalUsername").textContent = username;

                document.getElementById("resultUsername").textContent = username;
            });

            document.getElementById("btnConfirmReset").addEventListener("click", function() {
                $('#resetPasswordModal').modal('hide');
                setTimeout(() => {
                    $('#resetResultModal').modal('show');
                }, 500);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            $('#banUser').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');

                document.getElementById("modalBanUsername").textContent = username;

                document.getElementById("resultBanUsername").textContent = username;
            });

            document.getElementById("btnConfirmBan").addEventListener("click", function() {
                $('#banUser').modal('hide');
                setTimeout(() => {
                    $('#banResultModal').modal('show');
                }, 500);
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            $('#uploadSuratModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');
                let jumlahWarnings = button.data('warnings');

                document.getElementById("jumlahwarnings").textContent = jumlahWarnings;
                document.getElementById("SPUsername").textContent = username;;

            });
        });
    </script>
@endsection

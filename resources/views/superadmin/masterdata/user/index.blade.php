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
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-outline-primary"><i
                                    class="fa fa-arrow-left"></i> Kembali</a>
                            <a href="{{ route('admin-user.create') }}" class="btn btn-primary">Tambah
                                Data</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        {{ $dataTable->table([
                            'class' => 'table table-bordered table-striped',
                        ]) }}
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

    {{-- START RESET PASSWORD --}}
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
                <form id="formResetPassword" action="#" method="POST" hidden>
                    @csrf
                    @method('PUT')
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="formResetPassword" class="btn btn-warning">Ya, Reset</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END RESET PASSWORD --}}

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

    {{-- START BAN USER --}}
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
                <form id="formBanUser" action="#" method="post" hidden>
                    @csrf
                    @method('PUT')
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="formBanUser" class="btn btn-danger">Ya, Ban User</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END BAN USER --}}

    {{-- START UNBAND USER --}}
    <div class="modal fade" id="unbanUser" tabindex="-1" role="dialog" aria-labelledby="unbanUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="unbanUserModalLabel">Konfirmasi Unban User</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah Anda yakin ingin mengembalikan akses user <strong id="modalUnbanUsername">user</strong>?
                </div>
                <form id="formUnbanUser" action="#" method="post" hidden>
                    @csrf
                    @method('PUT')
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" form="formUnbanUser" class="btn btn-success">Ya, Unban User</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END UNBAND USER --}}

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

    {{-- START SURAT PERINGATAN --}}
    <div class="modal fade" id="uploadSuratModal" tabindex="-1" aria-labelledby="uploadSuratModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formSuratPeringatan" action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="uploadSuratModalLabel">Upload Surat Teguran</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 text-end">
                            <a href="{{ route('admin.surat-peringatan.index') }}" class="btn btn-danger w-100">
                                <i class="fa fa-list"></i> Daftar Semua Surat Peringatan
                            </a>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Nama PJLP:</label><br>
                            <strong id="SPUsername">user</strong>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis:</label>
                            <select class="form-control" name="jenis" id="jenis" required>
                                <option value="" selected disabled>- pilih jenis teguran -</option>
                                <option value="SP1">SP1</option>
                                <option value="SP2">SP2</option>
                                <option value="SP3">SP3</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File:</label>
                            <input type="file" class="form-control" name="file" accept="application/pdf" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal:</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan:</label>
                            <textarea class="form-control" name="alasan" id="alasan" required rows="4" placeholder="input alasan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sanksi" class="form-label">Sanksi:</label>
                            <textarea class="form-control" name="sanksi" id="sanksi" required rows="4" placeholder="input sanksi"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Jumlah Surat Peringatan Personel:</label><br>
                            <strong id="jumlahwarnings">0</strong> Surat
                            Teguran
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END SURAT PERINGATAN --}}
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush

@section('javascript')
    <script type="text/javascript">
        function toggleModal(id) {
            $('#id').val(id);
        }

        document.addEventListener("DOMContentLoaded", function() {
            $('#resetPasswordModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');
                let url = button.data('url');

                document.getElementById("modalUsername").textContent = username;
                document.getElementById("resultUsername").textContent = username;
                document.getElementById("formResetPassword").action = url;
            });

            document.getElementById("btnConfirmReset").addEventListener("click", function() {
                $('#resetPasswordModal').modal('hide');
                setTimeout(() => {
                    $('#resetResultModal').modal('show');
                }, 500);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // === Modal BAN ===
            $('#banUser').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');
                let url = button.data('url');

                document.getElementById("modalBanUsername").textContent = username;
                document.getElementById("formBanUser").action = url;
            });

            // === Modal UNBAN ===
            $('#unbanUser').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');
                let url = button.data('url');

                document.getElementById("modalUnbanUsername").textContent = username;
                document.getElementById("formUnbanUser").action = url;
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            $('#uploadSuratModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let username = button.data('username');
                let jumlahWarnings = button.data('warnings');
                let url = button.data('url');

                document.getElementById("jumlahwarnings").textContent = jumlahWarnings;
                document.getElementById("SPUsername").textContent = username;
                document.getElementById("formSuratPeringatan").action = url;
            });
        });
    </script>
@endsection

@extends('layout.base')

@section('title-head')
    <title>
        Superadmin | Data Kinerja
    </title>
@endsection

@section('path')
    <div class="page-header">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Superadmin</li>
            <li class="breadcrumb-item">Arsip Data</li>
            <li class="breadcrumb-item active">Data Kinerja</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="task-section">
                <div class="row no-gutters">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-4">
                        <div class="labels-container">
                            <div class="mt-5"></div>
                            <div class="lablesContainerScroll">
                                <div class="filters-block">
                                    <h5>Arsip Tahun</h5>
                                    <div class="filters">
                                        @for ($y = 2024; $y <= date('Y'); $y++)
                                            <a href="javascript:void(0);"
                                                class="year-link {{ $y == $tahun ? 'active' : '' }}"
                                                data-year="{{ $y }}">
                                                <i class="icon-receipt"></i>
                                                {{ $y }}
                                                @if ($y == date('Y'))
                                                    (Tahun Berjalan)
                                                @endif
                                            </a>
                                        @endfor
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-9 col-sm-9 col-8">
                        <div class="tasks-container">
                            <div class="tasks-header">
                                <h3 id="kinerja-title">Arsip Kinerja - {{ $tahun }}</h3>
                            </div>
                            <div class="tasksContainerScroll">
                                <div class="row no-gutters justify-content-center">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <form class="form-inline mb-2">
                                                            <input class="form-control mr-sm-2" type="search"
                                                                placeholder="Cari sesuatu di sini..." aria-label="Search"
                                                                id="search-bar">
                                                            <button class="btn btn-dark my-2 my-sm-0"
                                                                type="submit">Pencarian</button>
                                                        </form>
                                                    </div>
                                                    <div
                                                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 text-left">
                                                        <a href="{{ route('dashboard.index') }}"
                                                            class="btn btn-outline-primary"><i
                                                                class="fa fa-arrow-left"></i>Kembali</a>
                                                        <button data-toggle="modal" data-target="#modalDownloadExcel"
                                                            title="Export Excel" class="btn btn-primary">
                                                            <i class="fa fa-file-excel"></i>
                                                            Export to Excel
                                                        </button>
                                                        <a href="javascript:;" title="Filter" class="btn btn-primary"
                                                            data-toggle="modal" data-target="#modalFilter"><i
                                                                class="fa fa-filter"></i> Filter</a>
                                                        <a href="#" class="btn btn-primary" title="Reset Filter">
                                                            <i class="fa fa-refresh"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <div class="table-responsive mt-2">
                                                        <table class="table table-bordered table-striped" id="dataTable">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No.</th>
                                                                    <th class="text-center">No. Tiket</th>
                                                                    <th class="text-center">Tanggal</th>
                                                                    <th class="text-center">Nama</th>
                                                                    <th class="text-center">NIP</th>
                                                                    <th class="text-center">Koordinator</th>
                                                                    <th class="text-center">Tim</th>
                                                                    <th class="text-center">Seksi</th>
                                                                    <th class="text-center">Pulau</th>
                                                                    <th class="text-center">Giat/Pekerjaan</th>
                                                                    <th class="text-center">Lokasi</th>
                                                                    <th class="text-center">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            {{-- <tbody>
                                                                @foreach ($kinerja as $item)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                                        <td class="text-center">{{ $item->ticket_number }}
                                                                        </td>
                                                                        <td class="text-center">{{ $item->tanggal }}</td>
                                                                        <td class="text-center">{{ $item->anggota->name }}
                                                                        </td>
                                                                        <td class="text-center">{{ $item->anggota->nip }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $item->koordinator->name }}</td>
                                                                        <td class="text-center">{{ $item->tim->name }}</td>
                                                                        <td class="text-center">{{ $item->seksi->name }}
                                                                        </td>
                                                                        <td class="text-center">{{ $item->pulau->name }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $item->kategori->name ?? $item->kegiatan }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ $item->lokasi }}
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <button class="btn btn-outline-primary"
                                                                                data-toggle="modal"
                                                                                data-target="#detailKinerja"
                                                                                data-photo='{{ $item->photo }}'>
                                                                                <i class="fa fa-eye"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @if ($kinerja->count() == 0)
                                                                    <tr>
                                                                        <td class="text-center" colspan="12">
                                                                            Tidak ada data.
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody> --}}
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const yearLinks = document.querySelectorAll(".year-link");

            yearLinks.forEach(link => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    let year = this.dataset.year;

                    document.getElementById("kinerja-title").innerHTML = "Arsip Kinerja - " + year;

                    yearLinks.forEach(l => l.classList.remove("active"));

                    this.classList.add("active");
                });
            });
        });
    </script>
@endsection

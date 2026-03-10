<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - {{ $user->anggota->name }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/ukt2logo.png') }}" />
    <style>
        /* @page {
            margin: 20mm 5mm 20mm 5mm;
        } */

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        .mt-2 {
            margin-top: 0.75rem;
        }

        .mb-1 {
            margin-bottom: .25rem;
        }

        .ml-4 {
            margin-left: 1.5rem;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        u {
            text-decoration: underline;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered,
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
        }

        .table th,
        .table td {
            padding: 4px;
        }

        .py-1 {
            padding-top: 1px !important;
            padding-bottom: 1px !important;
        }

        .table-borderless td {
            border: none;
        }

        .img-thumbnail {
            border: 1px solid #ddd;
            padding: 2px;
            border-radius: 5px;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .header img {
            height: 60px;
        }

        .header .left {
            float: left;
        }

        .header .right {
            float: right;
        }

        .clearfix {
            clear: both;
        }

        .footer {
            position: fixed;
            bottom: -330px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .page-break {
            page-break-after: always;
        }

        /* Header box like Bootstrap */
        .summary-box {
            display: inline-block;
            background: #90ee90;
            padding: 18px;
            width: 20%;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-right: 2%;
        }

        .bg-yellow {
            background-color:#ffe282;
        }

        .bg-warning {
            background-color:#ffe282;
        }

        .bg-danger {
            background-color:#fe8787;
        }

        .photo-cell {
            vertical-align: middle;
            text-align: center;
            padding: 5px;
            /* height: 60px; */
            white-space: nowrap;
        }

        .photo-cell img {
            display: inline-block;
            height: 60px;
            width: auto;
            margin: 5px 2px 0 0;
            vertical-align: middle;
        }

        h5 {
            font-size: 1.1rem; /* Sedikit lebih besar dari teks biasa */
            font-weight: 600; /* Semi-bold */
            color: #333; /* Abu-abu gelap */
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
    </style>
</head>

<body>
    {{-- <div class="header">
        <img style="height: 60px" src="{{ public_path('assets/img/logo-ukt2.png') }}" alt="logo-ukt2">
    </div>

    <div class="footer">
        <i> SIMOJA © {{ \Carbon\Carbon::now()->translatedFormat('Y') }}</i>
    </div> --}}

    {{-- PAGE SUMMARY --}}
    <div class="text-center">
        <h5 class="mt-3 mb-1 text-uppercase font-weight-bold">
            <u>LAPORAN KEHADIRAN</u>
        </h5>
    </div>
    <div class="mt-2">
        <table class="ml-4 p-0" style="font-size: 14px">
            <tr>
                <td style="width: 20mm">Nama</td>
                <td style="width: 5mm">:</td>
                <td class="font-weight-bold text-uppercase">{{ $user->anggota->name }}</td>
            </tr>
            <tr>
                <td>ID PJLP</td>
                <td>:</td>
                <td>{{ $user->anggota->nip }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $user->anggota->jabatan->name }}</td>
            </tr>
            {{-- <tr>
                <td>Koordinator</td>
                <td>:</td>
                <td>{{ $user->koordinator->name }}</td>
            </tr> --}}
            <tr>
                <td>Seksi</td>
                <td>:</td>
                <td>{{ $user->struktur->seksi->name }}</td>
            </tr>
            <tr>
                <td>Pulau</td>
                <td>:</td>
                <td>{{ $user->area->pulau->name }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ $start_date }} s/d {{ $end_date }}</td>
            </tr>
        </table>
    </div>

    <p class="text-center mt-3 text-uppercase font-weight-bold"><u>RANGKUMAN KEHADIRAN</u></p>

    <p class="ml-4"><u>Total Hari Kerja : {{ $jumlah_hari_kerja ?? 'N/A' }} Hari</u></p>
    <table class="table table-bordered" style="width:90%; margin:auto; font-size:13px;">
        <thead>
            <tr class="text-center text-uppercase" style="background-color: grey">
                <th>No</th>
                <th>Jenis Presensi</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Presensi Masuk & Pulang</td>
                <td class="text-center">{{ $jumlah_hari_masuk ?? 'N/A' }}</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Presensi Tidak Lengkap</td>
                <td class="text-center">{{ $jumlah_hari_tidak_lengkap ?? 'N/A' }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Presensi Tidak Tertib</td>
                <td class="text-center">{{ $jumlah_hari_tidak_ok ?? 'N/A' }}</td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td>Tidak Hadir</td>
                <td class="text-center">{{ $jumlah_hari_tidak_masuk ?? 'N/A' }}</td>
                <td class="text-left">
                    Cuti: {{ $cuti ?? 'N/A' }} <br>
                    Sakit: {{ $sakit ?? 'N/A' }} <br>
                    Tanpa Keterangan: {{ $jumlah_hari_tidak_lengkap ?? 'N/A' }}
                </td>
            </tr>
        </tbody>
    </table>

    <div style="text-align:center; margin-top:50px;">

        @php
            function getColor($value)
            {
                if ($value === null) {
                    return '#d3d3d3'; // abu-abu kalau N/A
                } elseif ($value >= 90) {
                    return '#90ee90'; // hijau muda
                } elseif ($value >= 70) {
                    return '#fffacd'; // kuning muda
                } else {
                    return '#f08080'; // merah muda
                }
            }
        @endphp

        <div
            style="display:inline-block; background:{{ getColor($persentase_kehadiran ?? null) }}; color:#000; padding:18px; width:20%; text-align:center; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); margin-right:2%;">
            <div style="font-size:50px; font-weight:bold;">{{ $persentase_kehadiran ?? 'N/A' }}%</div>
            <div style="margin-top:5px; font-size:14px;">
                Tingkat Kehadiran <br>
                <p style="font-size:10px">{{ $jumlah_hari_masuk ?? 'N/A' }}/{{ $jumlah_hari_kerja ?? 'N/A' }} Hari</p>
            </div>
        </div>

        <div
            style="display:inline-block; background:{{ getColor($persentase_ketertiban ?? null) }}; color:#000; padding:18px; width:20%; text-align:center; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); margin-right:2%;">
            <div style="font-size:50px; font-weight:bold;">{{ $persentase_ketertiban ?? 'N/A' }}%</div>
            <div style="margin-top:5px; font-size:14px;">
                Tingkat Ketertiban <br>
                <p style="font-size:10px">{{ $jumlah_hari_ok ?? 'N/A' }}/{{ $jumlah_hari_kerja ?? 'N/A' }} Hari</p>
            </div>
        </div>

        <div
            style="display:inline-block; background:{{ getColor($persentase_jam_kerja_aktual ?? null) }}; color:#000; padding:18px; width:20%; text-align:center; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1);">
            <div style="font-size:50px; font-weight:bold;">{{ $persentase_jam_kerja_aktual ?? 'N/A' }}%</div>
            <div style="margin-top:5px; font-size:14px;">
                Efisiensi Kerja <br>
                <p style="font-size:10px">{{ $total_jam_kerja_aktual ?? 'N/A' }}/{{ $total_jam_kerja ?? 'N/A' }} Jam
                </p>
            </div>
        </div>
    </div>

    <div style="font-size:12px;" class="ml-4">
        <p><u>Catatan: </u></p>
        <p>% Tingkat Kehadiran: Presentase Kehadiran & Ketidakhadiran dari Data Absensi</p>
        <p>% Tingkat Ketertiban: Presentase Ketertiban & Kesesuaian Absen Masuk & Pulang</p>
        <p>% Efisiensi Kerja: Presentase Jam Kerja Efektif terhadap Jam Absensi</p>
    </div>

    <div class="page-break"></div>

    {{-- PAGE DETAIL --}}
    <div class="text-center">
        <p class="mt-3 mb-1 text-uppercase font-weight-bold">
            <u>DETAIL KEHADIRAN</u>
        </p>
    </div>

    <div class="mt-2">
        <table class="ml-4 p-0" style="font-size: 14px">
            <tr>
                <td style="width: 20mm">Nama</td>
                <td style="width: 5mm">:</td>
                <td class="font-weight-bold text-uppercase" style="width: auto">{{ $user->anggota->name }}</td>
            </tr>
            <tr>
                <td>ID PJLP</td>
                <td>:</td>
                <td>{{ $user->anggota->nip }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $user->anggota->jabatan->name }}</td>
            </tr>
            {{-- <tr>
                <td>Koordinator</td>
                <td>:</td>
                <td>{{ $user->koordinator->name }}</td>
            </tr> --}}
            <tr>
                <td>Seksi</td>
                <td>:</td>
                <td>{{ $user->struktur->seksi->name }}</td>
            </tr>
            <tr>
                <td>Pulau</td>
                <td>:</td>
                <td>{{ $user->area->pulau->name }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>{{ $start_date }} s/d {{ $end_date }}</td>
            </tr>
        </table>
    </div>

    <div class="mt-3">
        <table class="table table-bordered text-center p-1" style="font-size: 12px">
            <thead>
                <tr class="text-center text-uppercase" style="background-color: grey">
                    <th>No.</th>
                    <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Jam Datang</th>
                    <th>Jam Pulang</th>
                    <th>Photo Datang</th>
                    <th>Photo Pulang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datesInRange as $item)
                    <tr>
                        <td class="p-1">{{ $loop->iteration }}</td>
                        <td class="p-1">{{ $item['hari'] }}</td>
                        <td class="p-1">{{ $item['tanggal']->isoFormat('D MMMM Y') }}</td>
                        <td class="p-1">
                            {{ $item['jam_masuk'] }}
                            <p>{{ $item['status_masuk'] }}</p>
                        </td>
                        <td class="p-1">
                            {{ $item['jam_pulang'] }}
                            <p>{{ $item['status_pulang'] }}</p>
                        </td>
                        <td class="p-1">
                            <img class="img-thumbnail" src="{{ $item['url_photo_masuk'] }}" alt="photo_datang"
                                style="height: 70px">
                        </td>
                        <td class="p-1">
                            <img class="img-thumbnail" src="{{ $item['url_photo_pulang'] }}" alt="photo_pulang"
                                style="height: 70px">
                        </td>
                        <td class="{{ $item['bg'] }} p-1">{{ $item['status'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <div class="page-break"></div> --}}

    {{-- PAGE DETAIL --}}
    <div class="text-center mt-5">
        <p class="mt-3 mb-1 text-uppercase font-weight-bold">
            <u>PERSETUJUAN</u>
        </p>
    </div>

    <div class="mt-5 text-center" style="margin-top: 30px; font-size: 14px">
        <table class="table table-borderless">
            <tr>
                <td style="width: 7cm" class="text-center p-0">PJLP</td>
                <td></td>
                <td style="width: 7cm" class="text-center p-0">
                    @if ($kepala_seksi->is_plt == true)
                        Plt.
                    @endif Kepala Seksi {{ $user->struktur->seksi->name ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="text-center p-0">
                    Seksi {{ $user->struktur->seksi->name ?? 'N/A' }}
                </td>
                <td></td>
                <td class="text-center p-0">
                    {{ $user->struktur->unitkerja->name ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <td class="py-1"></td>
                <td></td>
                <td class="text-center py-1">
                    Kabupaten Adm. Kepulauan Seribu
                </td>
            </tr>

            <tr>
                <td style="height: 40mm;"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center text-uppercase font-weight-bold p-0" style="border-bottom:1pt solid black;">
                    {{ $user->anggota->name ?? 'N/A' }}
                </td>
                <td></td>
                <td class="text-center text-uppercase font-weight-bold p-0" style="border-bottom:1pt solid black;">
                    {{ $kepala_seksi->name ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="text-center p-0">
                    ID PJLP. {{ $user->anggota->nip ?? 'N/A' }}
                </td>
                <td></td>
                <td class="text-center p-0">
                    NIP. {{ $kepala_seksi->nip ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

</body>

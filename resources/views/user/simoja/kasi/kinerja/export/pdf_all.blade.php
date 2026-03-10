<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja</title>
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

    <div>
        <div class="text-center">
            <h5 class="mb-0 text-uppercase font-weight-bold">
                <u>LAPORAN KINERJA</u>
            </h5>
        </div>
        <div class="mt-3">
            <table class="table table-bordered p-1" style="font-size: 10px">
                <thead>
                    <tr class="text-center text-uppercase" style="background-color: grey">
                        <th>No.</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Personel</th>
                        <th>Kegiatan</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kinerja as $item)
                        <tr>
                            <td class="text-center" rowspan="2">{{ $loop->iteration }}</td>
                            <td class="text-nowrap">{{ $item->hari }}</td>
                            <td class="text-nowrap">{{ $item->formatted_tanggal }}</td>
                            <td class="text-nowrap font-weight-bold">{{ $item->anggota->name ?? '-' }}</td>
                            <td class="text-wrap">{{ $item->kategori->name ?? $item->kegiatan }}</td>
                            <td class="text-wrap">{{ $item->lokasi }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="mb-0">
                                @if($item->photo != null)
                                    @foreach (json_decode($item->photo, true) as $photo)
                                        <img class="img-thumbnail" style="height: 80px" src="{{ public_path('storage/' . $photo) }}" alt="Foto Kegiatan">
                                    @endforeach
                                @endif
                                <p class="mb-0">Catatan: {{ $item->deskripsi ?? '-' }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

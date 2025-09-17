<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja - {{ $kategori->name }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            margin: 20mm 5mm 20mm 5mm;
        }

        .header {
            position: fixed;
            top: -65px;
            left: 20px;
            right: 0px;
            height: 60px;
            text-align: left;
            line-height: 35px;
        }

        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 12px;
            color: #555;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="header">
        <img style="height: 60px" src="{{ public_path('assets/img/logo-ukt2.png') }}" alt="logo-ukt2">
    </div>

    <div class="footer">
        <i> SIMOJA © {{ \Carbon\Carbon::now()->translatedFormat('Y') }}</i>
    </div>
    <div>
        <div class="text-center">
            <p class="mb-1 text-uppercase font-weight-bold">
                <u>LAPORAN KINERJA PER KEGIATAN</u>
            </p>
        </div>
        <div class="mt-3">
            <table class="ml-4 p-0" style="font-size: 12px">
                <tr>
                    <td style="width: 20mm">Kegiatan</td>
                    <td style="width: 5mm">:</td>
                    <td class="text-wrap">{{ $kategori->name }}</td>
                    <td style="width: 5mm"></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td>{{ $start_date }} s/d {{ $end_date }}</td>
                </tr>
            </table>
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

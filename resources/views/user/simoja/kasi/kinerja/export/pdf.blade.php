<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - {{ $user->anggota->name }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            margin: 5mm 5mm 5mm 5mm;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div>
        <div class="text-center">
            <p class="mt-3 mb-1 text-uppercase font-weight-bold">
                <u>LAPORAN ABSENSI
                </u>
            </p>
        </div>
        <div class="mt-2">
            <table class="ml-4 p-0" style="font-size: 14px">
                <tr>
                    <td style="width: 20mm">Nama</td>
                    <td style="width: 5mm">:</td>
                    <td class="font-weight-bold text-uppercase">{{ $user->anggota->name }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $user->anggota->nip }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $user->anggota->jabatan->name }}</td>
                </tr>
                <tr>
                    <td>Koordinator</td>
                    <td>:</td>
                    <td>{{ $user->koordinator->name }}</td>
                </tr>
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
                    <tr style="background-color: grey">
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
                            <td class="p-1">{{ $item['jam_masuk'] }}</td>
                            <td class="p-1">{{ $item['jam_pulang'] }}</td>
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
    </div>
</body>

</html>

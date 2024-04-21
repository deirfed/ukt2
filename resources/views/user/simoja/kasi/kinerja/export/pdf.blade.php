<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kinerja - {{ $user->anggota->name }}</title>
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
                <u>LAPORAN KINERJA
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
                    <td>ID PJLP</td>
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
                        <th>Kegiatan</th>
                        <th>Deskripsi</th>
                        <th>Lokasi</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datesInRange as $item)
                        <tr>
                            <td class="p-1">{{ $loop->iteration }}</td>
                            <td class="p-1">{{ $item['hari'] }}</td>
                            <td class="p-1">{{ $item['tanggal']->isoFormat('D MMMM Y') }}</td>
                            <td class="p-2 text-wrap text-left">
                                <ol class="p-3">
                                    @if ($item['kegiatan'] != null)
                                        @foreach ($item['kegiatan'] as $kegiatan)
                                            <li>{{ $kegiatan }}</li>
                                        @endforeach
                                    @endif
                                </ol>
                            </td>
                            <td class="p-2 text-wrap text-left">
                                <ol class="p-3">
                                    @if ($item['deskripsi'] != null)
                                        @foreach ($item['deskripsi'] as $deskripsi)
                                            <li>{{ $deskripsi }}</li>
                                        @endforeach
                                    @endif
                                </ol>
                            </td>
                            <td class="p-2 text-wrap text-left">
                                <ol class="p-3">
                                    @if ($item['lokasi'] != null)
                                        @foreach ($item['lokasi'] as $lokasi)
                                            <li>{{ $lokasi }}</li>
                                        @endforeach
                                    @endif
                                </ol>
                            </td>
                            <td class="text-left p-2 {{ $item['bg'] }}" style="width: 11cm">
                                <ol class="p-3">
                                    @if ($item['photo'] != null)
                                        @foreach ($item['photo'] as $photos)
                                            <li>
                                                @foreach (json_decode($photos) as $photo)
                                                    <img class="img-thumbnail"
                                                        src="{{ public_path('storage/' . $photo) }}" alt="photo"
                                                        style="height: 64px">
                                                @endforeach
                                            </li>
                                        @endforeach
                                    @endif
                                </ol>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

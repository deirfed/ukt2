<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Absensi</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    No.
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Tanggal
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Nama
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    NIP
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Jabatan
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Pulau
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Seksi
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Jam Datang
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Telat Datang (Menit)
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Status Datang
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Catatan Masuk
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Jam Pulang
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Cepat Pulang (Menit)
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Status Pulang
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Catatan Pulang
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Status
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Photo Datang
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Photo Pulang
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->formatted_tanggal }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->user->nip }}</td>
                    <td>{{ $item->user->jabatan->name }}</td>
                    <td>{{ $item->user->area->pulau->name }}</td>
                    <td>{{ $item->user->struktur->seksi->name }}</td>
                    <td>{{ $item->jam_masuk }}</td>
                    <td>{{ $item->telat_masuk }}</td>
                    <td>{{ $item->status_masuk }}</td>
                    <td>{{ $item->catatan_masuk }}</td>
                    <td>{{ $item->jam_pulang }}</td>
                    <td>{{ $item->cepat_pulang }}</td>
                    <td>{{ $item->status_pulang }}</td>
                    <td>{{ $item->catatan_pulang }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        {{ $item->photo_masuk ? asset('storage/' . $item->photo_masuk) : '' }}
                    </td>
                    <td>
                        {{ $item->photo_pulang ? asset('storage/' . $item->photo_pulang) : '' }}
                    </td>
                </tr>
            @endforeach
            @if ($absensi->count() == 0)
                <tr>
                    <td style="text-align: center;" colspan="18">
                        Tidak ada data.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>

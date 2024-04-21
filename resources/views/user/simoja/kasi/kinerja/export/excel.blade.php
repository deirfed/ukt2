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
                    Koordinator
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Giat/Pekerjaan
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Deskripsi
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Lokasi
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Dokumentasi Kegiatan 1
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Dokumentasi Kegiatan 2
                </th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                    Dokumentasi Kegiatan 3
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kinerja as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->anggota->name }}</td>
                    <td>{{ $item->anggota->nip }}</td>
                    <td>{{ $item->anggota->jabatan->name }}</td>
                    <td>{{ $item->anggota->area->pulau->name }}</td>
                    <td>{{ $item->anggota->struktur->seksi->name }}</td>
                    <td>{{ $item->koordinator->name }}</td>
                    <td>{{ $item->kategori->name ?? $item->kegiatan }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->lokasi }}</td>
                    @if ($item->photo != null)
                        @foreach (json_decode($item->photo) as $photo)
                            <td>
                                {{ asset('storage/' . $photo) }}
                            </td>
                        @endforeach
                    @endif
                </tr>
            @endforeach
            @if ($kinerja->count() == 0)
                <tr>
                    <td style="text-align: center;" colspan="14">
                        Tidak ada data.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>

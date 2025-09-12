<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Data Cuti</title>
    </head>

    <body>
        <table>
            <thead>
                <tr>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        No.
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
                        Tim
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Tanggal Mulai
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Tanggal Selesai
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Jenis Izin
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Jumlah Hari
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Koordinator
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Disetujui
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Status
                    </th>
                    <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">
                        Lampiran
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuti as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->user->nip }}</td>
                        <td>{{ $item->user->jabatan->name }}</td>
                        <td>{{ $item->user->area->pulau->name }}</td>
                        <td>{{ $item->user->struktur->seksi->name }}</td>
                        <td>{{ $item->user->struktur->tim->name }}</td>
                        <td>
                            {{ $item->tanggal_awal }}
                        </td>
                        <td>
                            {{ $item->tanggal_akhir }}
                        </td>
                        <td>{{ $item->jenis_cuti->name }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>
                            {{ $item->known_by->name }}
                        </td>
                        <td>
                            @if ($item->status == 'Diterima')
                                {{ $item->approved_by->name }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            {{ $item->status }}
                        </td>
                        <td>
                            {{ $item->lampiran ? asset('storage/' . $item->lampiran) : '' }}
                        </td>
                    </tr>
                @endforeach
                @if ($cuti->count() == 0)
                    <tr>
                        <td style="text-align: center;" colspan="13">
                            Tidak ada data.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </body>

</html>

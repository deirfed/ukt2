<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Transaksi Barang</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">No.</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">PIC</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Gudang</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Seksi</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Nama Barang</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Jenis Barang</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Tanggal</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Qty</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Satuan</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Kegiatan</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Catatan</th>
                <th style="border: 3px; background-color:gray; font-weight:bolder; text-align:center;">Photo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->barang_pulau->gudang->name }}</td>
                    <td>{{ $item->barang_pulau->barang->kontrak->seksi->name }}</td>
                    <td>{{ $item->barang_pulau->barang->name }}</td>
                    <td>{{ $item->barang_pulau->barang->jenis }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->barang_pulau->barang->satuan }}</td>
                    <td>{{ $item->kegiatan }}</td>
                    <td>{{ $item->catatan }}</td>
                    <td>
                        {{ asset('storage/' . $item->photo) }}
                    </td>
                </tr>
            @endforeach
            @if ($transaksi->count() == 0)
                <tr>
                    <td style="text-align: center;" colspan="12">
                        Tidak ada data.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>

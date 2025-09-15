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
    <style>
        @page {
            margin: 20mm 5mm 20mm 5mm;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 10px;
            color: #555;
        }

        .content {
            margin-bottom: 25mm;
        }
    </style>
</head>

<body>
    <div>
        <div class="text-center">
            <h5 class="mt-3 mb-1 text-uppercase font-weight-bold">
                <u>LAPORAN PRESENSI
                </u>
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

        <p class="text-center mt-3 text-uppercase font-weight-bold"><u>SUMMARY PRESENSI</u></p>

        <p class="ml-4"><u>Total Hari Kerja : {{ $jumlah_hari_kerja ?? 'N/A' }} Hari</u></p>
        <table class="table table-bordered" style="width:90%; margin:auto; font-size:13px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Presensi</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Presensi Masuk & Pulang</td>
                    <td class="text-center">{{ $jumlah_hari_masuk ?? 'N/A' }}</td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Presensi Tidak Lengkap</td>
                    <td class="text-center">{{ $jumlah_hari_tidak_lengkap ?? 'N/A' }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Presensi Tidak Tertib</td>
                    <td class="text-center">{{ $jumlah_hari_tidak_ok ?? 'N/A' }}</td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td>4</td>
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
                    <p style="font-size:10px">{{ $total_jam_kerja_aktual ?? 'N/A' }}/{{ $total_jam_kerja ?? 'N/A' }} Jam</p>
                </div>
            </div>
        </div>

        <div style="font-size:12px;" class="ml-4">
            <p><u>Catatan: </u></p>
            <p>% Tingkat Kehadiran: Presentase Kehadiran & Ketidakhadiran dari Data Absensi</p>
            <p>% Tingkat Ketertiban: Presentase Ketertiban & Kesesuaian Absen Masuk & Pulang</p>
            <p>% Efisiensi Kerja: Presentase Jam Kerja Efektif terhadap Jam Absensi</p>
        </div>

        <div class="footer">
            <i> SIMOJA - Dibuat {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</i>
        </div>

    </div>

    <div class="page-break"></div>

    <div class="text-center">
        <p class="mt-3 mb-1 text-uppercase font-weight-bold">
            <u>DETAIL PRESENSI
            </u>
        </p>
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

    <div class="mt-5 text-center" style="margin-top: 30px; font-size: 14px">
        <table class="table table-borderless">
            <tr>
                <td class="text-center p-0">Koordinator</td>
                <td style="width: 4cm"></td>
                <td class="text-center p-0">Kepala Seksi</td>
            </tr>
            <tr>
                <td class="text-center p-0">Pulau {{ $user->area->pulau->name ?? 'N/A' }}</td>
                <td></td>
                <td class="text-center p-0">{{ $user->struktur->seksi->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="height: 27mm;"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center text-uppercase font-weight-bold p-0" style="border-bottom:1pt solid black;">
                    {{ $user->koordinator->name ?? '-'  }}
                </td>
                <td></td>
                <td class="text-center text-uppercase font-weight-bold p-0" style="border-bottom:1pt solid black;">
                    {{ $kepala_seksi->name ?? 'N/A' }}
                </td>
            </tr>
            <tr>
                <td class="text-center p-0">
                    NIP. {{ $user->koordinator->nip ?? '-'  }}
                </td>
                <td></td>
                <td class="text-center p-0">
                    NIP. {{ $kepala_seksi->nip ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <i> SIMOJA - Dibuat {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</i>
    </div>
</body>

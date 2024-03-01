<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Surat Izin Cuti Tahunan</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @page {
                margin: 5mm 20mm 5mm 20mm;
            }

            .page-break {
                page-break-after: always;
            }
        </style>
    </head>

    <body>
        <div>
            <div class="text-center">
                <p class="mt-5 mb-1 text-uppercase font-weight-bold">
                    <u>SURAT IZIN @if ($cuti->jenis_cuti->id == 1)
                            CUTI TAHUNAN
                        @else
                            SAKIT
                        @endif
                    </u>
                </p>
                <p class="mt-1">Nomor: ___/__.__.__</p>
            </div>
            <div class="mt-5">
                <ol>
                    <li class="text-justify mb-1">
                        Diberikan {{ $cuti->jenis_cuti->name ?? '-' }} @if ($cuti->jenis_cuti->id == 1)
                            {{ $tahun ?? '-' }}
                        @endif kepada Penyedia Jasa Lainnya
                        Perorangan dengan Perjanjian Kontrak
                        (PJLP)
                        <table class="ml-3 mt-1">
                            <tbody>
                                <tr>
                                    <td style="width: 25mm">Nama</td>
                                    <td style="width: 3mm">:</td>
                                    <td class="font-weight-bold">
                                        {{ $cuti->user->name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>
                                        {{ $cuti->user->nip ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>
                                        {{ $cuti->user->jabatan->name ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td>
                                        {{ $cuti->user->struktur->unitkerja->name ?? '-' }} Setkab. Adm. Kep. Seribu
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="mt-3 mb-1 text-justify">
                            Selama <span class="font-weight-bold">{{ $cuti->jumlah ?? '-' }} hari</span> pada tanggal
                            <span class="font-weight-bold">{{ $tanggal ?? '-' }}</span>, dengan ketentuan
                            sebagai berikut:
                        </p>
                        <ol type="a" class="mt-1 text-justify">
                            <li>
                                Sebelum menjalankan cuti wajib menyelesaikan pekerjaan dan melaporkan kepada atasan
                                langsung.
                            </li>
                            <li>
                                Setelah menjalankan cuti wajib melaporkan diri kepada atasan langsung dan bekerja
                                kembali sebagaimana mestinya.
                            </li>
                        </ol>
                    </li>
                    <li class="mt-3 text-justify">
                        Demikian Surat Izin ini dibuat untuk dapat
                        dipergunakan sebagaimana mestinya.
                    </li>
                </ol>
            </div>
            <div class="mt-5 text-center">
                <table>
                    <tbody>
                        <tr>
                            <td style="width: 85mm"></td>
                            <td class="text-center">
                                <p>
                                    {{ $tanggal_approve ?? '-' }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center p-0">{{ $cuti->approved_by->jabatan->name ?? '-' }}
                                {{ $cuti->approved_by->struktur->seksi->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center p-0">Sekretariat Kabupaten Adm. Kep. Seribu</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                <div>
                                    <img style="height: 35mm"
                                        src="{{ public_path('storage/' . $cuti->approved_by->ttd) }}" alt="TTD">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center" style="border-bottom:1pt solid black;">
                                <span class="font-weight-bold">
                                    {{ $cuti->approved_by->name ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                NIP. {{ $cuti->approved_by->nip ?? '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <p class="mb-0">Tembusan:</p>
                <ol class="mt-0">
                    <li>Bupati Kabupaten Adm. Kep. Seribu</li>
                    <li>Panitia penerimaan Hasil Pekerjaan Sekretariat Kab. Kep. Seribu</li>
                </ol>
            </div>
        </div>

        @if ($cuti->lampiran != null)
            <div class="page-break"></div>

            <div>
                <div class="text-center">
                    <p class="mt-3 mb-2 text-uppercase font-weight-bold">
                        <u>Lampiran</u>
                    </p>
                    <div class="container">
                        <img class="img-thumbnail" style="height: 150mm"
                            src="{{ public_path('storage/' . $cuti->lampiran) }}" alt="Lampiran">
                    </div>
                </div>
            </div>
        @endif
    </body>

</html>

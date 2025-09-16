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
                <p class="mt-5 mb-0 text-uppercase font-weight-bold">
                    <u>SURAT IZIN @if ($cuti->jenis_cuti->id == 1)
                            CUTI TAHUNAN
                        @else
                            SAKIT
                        @endif
                    </u>
                </p>
                <p class="mt-0">Nomor: {{ $cuti->no_surat ?? '-' }}</p>
            </div>
            <div class="mt-5" style="font-size: 14px">
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
                            @if ($cuti->jenis_cuti->id == 1)
                                <li>
                                    Sebelum menjalankan cuti wajib menyelesaikan pekerjaan dan melaporkan kepada atasan
                                    langsung.
                                </li>
                                <li>
                                    Setelah menjalankan cuti wajib melaporkan diri kepada atasan langsung dan bekerja
                                    kembali sebagaimana mestinya.
                                </li>
                            @else
                                <li>
                                    Periksakan diri ke klinik/puskesmas/rumah sakit agar mendapatkan penanganan yang
                                    tepat.
                                </li>
                                <li>
                                    Segera melaporkan perkembangan kondisi kesehatan kepada atasan langsung dan kembali
                                    bekerja sebagaimana mestinya setelah pulih.
                                </li>
                            @endif
                        </ol>
                    </li>
                    <li class="mt-3 text-justify">
                        Demikian Surat Izin ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
                    </li>
                </ol>
            </div>
            <div class="mt-5 text-center" style="font-size: 14px">
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
                            <td class="text-center p-0">@if($cuti->approved_by->is_plt == true)Plt.@endif {{ $cuti->approved_by->jabatan->name ?? '-' }}
                                {{ $cuti->approved_by->struktur->seksi->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center p-0">Sekretariat Kabupaten Adm. Kep. Seribu</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                <div class="my-5"></div>
                                <div class="my-5">
                                    {{-- <img style="height: 35mm"
                                        src="{{ public_path('storage/' . $cuti->approved_by->ttd) }}" alt="TTD"> --}}
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

            <div class="mt-5" style="font-size: 14px">
                <p class="mb-0 mt-5">Tembusan:</p>
                <ol class="mt-0">
                    <li>Kepala Unit Kerja Teknis 2 Kabupaten Administrasi Kepulauan Seribu</li>
                    <li>Pejabat Pembuat Komitmen Unit Kerja Teknis 2 Kabupaten Administrasi Kepulauan Seribu</li>
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

<?php

namespace App\Exports\transaksi_barang_pulau;

use App\Models\TransaksiBarangPulau;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransaksiBarangPulauExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $transaksi = TransaksiBarangPulau::all();
        return view('pages.transaksi_barang_pulau.export.excel', [
            'transaksi' => $transaksi,
        ]);
    }
}

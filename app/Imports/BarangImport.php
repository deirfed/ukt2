<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    public $kontrak_id;

    public function __construct($kontrak_id)
    {
        $this->kontrak_id = $kontrak_id;
    }

    public function model(array $row)
    {
        return new Barang([
            'kontrak_id' => $this->kontrak_id,
            'name' => $row['nama'],
            'code' => $row['kode'],
            'merk' => $row['merk'],
            'jenis' => $row['jenis'],
            'stock_awal' => $row['stock_awal'],
            'stock_aktual' => $row['stock_aktual'],
            'satuan' => $row['satuan'],
            'harga' => $row['harga'],
            'spesifikasi' => $row['spesifikasi'],
        ]);
    }
}

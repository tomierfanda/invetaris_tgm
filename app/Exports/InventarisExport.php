<?php

namespace App\Exports;

use App\Models\Inventaris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventarisExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Inventaris::select(
            'nomor_lebelisasi',
            'nama_barang',
            'kode_barang',
            'tahun_pembelian',
            'barcode_path',
            'foto_lokasi'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Label',
            'Nama Barang',
            'Kode Barang',
            'Tahun Pembelian',
            'Barcode Path',
            'Foto Lokasi',
        ];
    }
}

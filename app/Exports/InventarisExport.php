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
            'kode_barang',
            'nama_barang',
            'nomor_register',
            'merk_type',
            'ukuran_cc',
            'bahan',
            'tahun_pembelian',
            'nomor_pabrik',
            'nomor_rangka',
            'nomor_mesin',
            'nomor_polisi',
            'nomor_bpkb',
            'asal_usul',
            'harga',
            'kondisi_simda',
            'kondisi_saat_ini',
            'keberadaan',
            'keterangan'
        )->get();
    }

   public function headings(): array
    {
        return [
            'Nomor Label',
            'Kode Barang',
            'Nama Barang',
            'Nomor Register',
            'Merk/Type',
            'Ukuran/CC',
            'Bahan',
            'Tahun Pembelian',
            'Nomor Pabrik',
            'Nomor Rangka',
            'Nomor Mesin',
            'Nomor Polisi',
            'Nomor BPKB',
            'Asal Usul',
            'Harga',
            'Kondisi (SIMDA)',
            'Kondisi Saat Ini',
            'Keberadaan',
            'Keterangan',
        ];
    }

}

<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inventaris extends Model
{
use HasFactory;


protected $table = 'inventaris';


protected $fillable = [
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
    'keterangan',
    'foto_lokasi',
    'barcode_path'
];

}

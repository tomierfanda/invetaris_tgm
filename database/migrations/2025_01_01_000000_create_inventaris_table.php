<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up(): void
{
    Schema::create('inventaris', function (Blueprint $table) {
    $table->id();
    $table->string('nomor_lebelisasi')->unique()->nullable();
    $table->string('kode_barang')->nullable();
    $table->string('nama_barang');
    $table->string('nomor_register')->nullable();
    $table->string('merk_type')->nullable();
    $table->string('ukuran_cc')->nullable();
    $table->string('bahan')->nullable();
    $table->year('tahun_pembelian')->nullable();
    $table->string('nomor_pabrik')->nullable();
    $table->string('nomor_rangka')->nullable();
    $table->string('nomor_mesin')->nullable();
    $table->string('nomor_polisi')->nullable();
    $table->string('nomor_bpkb')->nullable();
    $table->string('asal_usul')->nullable();
    $table->decimal('harga', 15, 2)->nullable();
    $table->string('kondisi_simda')->nullable();
    $table->string('kondisi_saat_ini')->nullable();
    $table->string('keberadaan')->nullable();
    $table->text('keterangan')->nullable();
    $table->string('foto_lokasi')->nullable();
    $table->string('barcode_path')->nullable();
    $table->timestamps();
    });
}


public function down(): void
{
Schema::dropIfExists('inventaris');
}
};

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

Route::get('/', function(){ 
    return redirect()->route('inventaris.index'); 
});

// Route Resource sudah membuat: .index, .create, .store, .show, .edit, .update, .destroy
Route::resource('inventaris', App\Http\Controllers\InventarisController::class)->parameters([
    // Ini bagus untuk memastikan parameter model binding menggunakan nama 'inventaris'
    'inventaris' => 'inventaris'
]);

// Route Tambahan (Ini unik, jadi aman)
Route::get('inventaris-search', [InventarisController::class, 'search'])->name('inventaris.search');
Route::get('inventaris/{id}/print-barcode', [InventarisController::class, 'printBarcode'])->name('inventaris.printBarcode');
Route::post('inventaris/export', [InventarisController::class, 'export'])->name('inventaris.export');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

Route::get('/', function(){ return redirect()->route('inventaris.index'); });
Route::resource('inventaris', App\Http\Controllers\InventarisController::class)->parameters([
    'inventaris' => 'inventaris'
]);
Route::get('/inventaris/{id}', [InventarisController::class, 'show'])->name('inventaris.show');
Route::get('inventaris-search', [InventarisController::class, 'search'])->name('inventaris.search');
Route::get('inventaris/{id}/print-barcode', [InventarisController::class, 'printBarcode'])->name('inventaris.printBarcode');
Route::post('inventaris/export', [InventarisController::class, 'export'])->name('inventaris.export');



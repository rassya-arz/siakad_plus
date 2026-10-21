<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KrsController;

Route::get('/', [KrsController::class, 'index']);
Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');

// Simulasi klik "Batal" pada tiap mata kuliah
Route::delete('/krs/{kode}', [KrsController::class, 'destroy'])->name('krs.destroy');

// Simulasi klik "Simpan KRS"
Route::post('/krs/simpan', [KrsController::class, 'store'])->name('krs.store');

// (Opsional) kembalikan data dummy ke kondisi awal: buka /krs/reset
Route::get('/krs/reset', [KrsController::class, 'reset'])->name('krs.reset');
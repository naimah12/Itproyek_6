<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/barangs', [BarangController::class, 'index'])->name('barang.index');
Route::get('/createBarang', [BarangController::class, 'create'])->name('barang.create');
Route::post('/store', [BarangController::class, 'store'])->name('barang.store');

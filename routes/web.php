<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\Detail_transaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Models\Kategori;
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

Route::get('/', [BarangController::class, 'index'])->name('barang.index');


//Barang
Route::get('/barangs', [BarangController::class, 'index'])->name('barang.index');

Route::get('/createBarang', [BarangController::class, 'create'])->name('barang.create');
Route::post('/storeBarang', [BarangController::class, 'store'])->name('barang.store');


Route::get('/editBarang/{id_barang}', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/updateBarang/{id_barang}', [BarangController::class, 'update'])->name('barang.update');

Route::delete('/deleteBarang/{id_barang}', [BarangController::class, 'delete'])->name('barang.delete');


//Kategori
Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategori.index');

Route::get('/createKategori', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/storeKategori', [KategoriController::class, 'store'])->name('kategori.store');

Route::get('/editKategori/{id_kategori}', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/updateKategori/{id_kategori}', [KategoriController::class, 'update'])->name('kategori.update');

Route::delete('/deleteKategori/{id_kategori}', [KategoriController::class, 'delete'])->name('kategori.delete');


// Detail Transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/create_transaksi', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::post('/trans_store', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::delete('transaksi/{id}', [TransaksiController::class, 'delete'])->name('transaksi.delete');
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');

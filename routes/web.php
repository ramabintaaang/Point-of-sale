<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    ///KATEGORI
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('addKategori2', [KategoriController::class, 'addKategori2'])->name('addKategori2');
    Route::get('editKategori2/{id}', [KategoriController::class, 'editKategori2'])->name('editKategori2');
    Route::post('updateKategori2', [KategoriController::class, 'updateKategori2'])->name('updateKategori2');
    Route::post('deleteKategori2/{id}', [KategoriController::class, 'deleteKategori2'])->name('deleteKategori2');
    Route::get('getKategori', [KategoriController::class, 'getKategori'])->name('getKategori');

    ///PRODUK
    Route::get('produk', [ProdukController::class, 'index'])->name('produk');
    Route::post('addProduk', [ProdukController::class, 'addProduk'])->name('addProduk');
    Route::get('editProduk/{id}', [ProdukController::class, 'editProduk'])->name('editProduk');
    Route::post('updateProduk', [ProdukController::class, 'updateProduk'])->name('updateProduk');
    Route::post('deleteProduk/{id}', [ProdukController::class, 'deleteProduk'])->name('deleteProduk');
    Route::post('deleteSelectProduk/{id}', [ProdukController::class, 'deleteSelectProduk'])->name('deleteSelectProduk');
    Route::get('getProduk', [ProdukController::class, 'getProduk'])->name('getProduk');
    Route::post('cetakBarcode', [ProdukController::class, 'cetakBarcode'])->name('cetakBarcode');

    // Route::get('optionKategori', [ProdukController::class, 'optionKategori'])->name('optionKategori');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('welcome');
// })->name('dashboard');

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PembelianDetailController;
use App\Http\Controllers\PengeluaranController;
use App\Models\PembelianDetail;
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


    ///Member
    Route::get('member', [MemberController::class, 'index'])->name('member');
    Route::post('addMember', [MemberController::class, 'addMember'])->name('addMember');
    Route::get('editMember/{id}', [MemberController::class, 'editMember'])->name('editMember');
    Route::post('updateMember', [MemberController::class, 'updateMember'])->name('updateMember');
    Route::post('deleteMember/{id}', [MemberController::class, 'deleteMember'])->name('deleteMember');
    Route::post('deleteSelectMember/{id}', [MemberController::class, 'deleteSelectMember'])->name('deleteSelectMember');
    Route::get('getMember', [MemberController::class, 'getMember'])->name('getMember');
    Route::post('cetakMember', [MemberController::class, 'cetakMember'])->name('cetakMember');


    ///Supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::post('addSupplier', [SupplierController::class, 'addSupplier'])->name('addSupplier');
    Route::get('editSupplier/{id}', [SupplierController::class, 'editSupplier'])->name('editSupplier');
    Route::post('updateSupplier', [SupplierController::class, 'updateSupplier'])->name('updateSupplier');
    Route::post('deleteSupplier/{id}', [SupplierController::class, 'deleteSupplier'])->name('deleteSupplier');
    Route::get('getSupplier', [SupplierController::class, 'getSupplier'])->name('getSupplier');


    ///Pengeluaran
    Route::get('pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
    Route::post('addPengeluaran', [PengeluaranController::class, 'addPengeluaran'])->name('addPengeluaran');
    Route::get('editPengeluaran/{id}', [PengeluaranController::class, 'editPengeluaran'])->name('editPengeluaran');
    Route::post('updatePengeluaran', [PengeluaranController::class, 'updatePengeluaran'])->name('updatePengeluaran');
    Route::post('deletePengeluaran/{id}', [PengeluaranController::class, 'deletePengeluaran'])->name('deletePengeluaran');
    Route::get('getPengeluaran', [PengeluaranController::class, 'getPengeluaran'])->name('getPengeluaran');


    ///Pembelian
    Route::get('pembelian', [PembelianController::class, 'index'])->name('pembelian');
    Route::get('dataSupplier/{id}', [PembelianController::class, 'dataSupplier'])->name('dataSupplier');
    Route::get('dataPembelian/{kode_pembelian}', [PembelianController::class, 'dataPembelian'])->name('dataPembelian');
    Route::get('getDataSupplier', [PembelianController::class, 'getDataSupplier'])->name('getDataSupplier');
    Route::get('getDataProduk', [PembelianController::class, 'getDataProduk'])->name('getDataProduk');
    Route::get('getDataProduk/{id}', [PembelianController::class, 'getDataProdukDetail'])->name('getDataProdukDetail');
    Route::get('getPembelianDetail', [PembelianController::class, 'getPembelianDetail'])->name('getPembelianDetail');
    Route::post('addPembelian', [PembelianController::class, 'addPembelian'])->name('addPembelian');
    Route::get('getPembelian', [PembelianController::class, 'getPembelian'])->name('getPembelian');
    Route::post('deletePembelian', [PembelianController::class, 'deletePembelian'])->name('deletePembelian');
    Route::post('deletePembelianFromBatal', [PembelianController::class, 'deletePembelianFromBatal'])->name('deletePembelianFromBatal');

    ///Detail Produk
    Route::post('addDetailProdukPembelian',[PembelianDetailController::class,'addDetailProdukPembelian'])->name('addDetailProdukPembelian');
    Route::get('getDetailProdukPembelian',[PembelianDetailController::class,'dt_pembelianDetail'])->name('getDetailProdukPembelian');
    // Route::get('optionKategori', [ProdukController::class, 'optionKategori'])->name('optionKategori');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('welcome');
// })->name('dashboard');

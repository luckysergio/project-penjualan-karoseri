<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChassisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisDumpController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SpkWpController;
use App\Http\Controllers\TypeDumpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->middleware('role:Pelanggan');

Route::get('/pesanan', [OrderController::class, 'pesanan'])->name('pesanan')->middleware('role:Pelanggan');

Route::get('/', [ProductController::class, 'home']);
Route::get('/', [SpkWpController::class, 'index']);


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:Admin,Karyawan');
Route::get('/api/dashboard-data', [DashboardController::class, 'getData']);

Route::get('/login', [AuthController::class, 'login']);
Route::post('/login1', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'registerView']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/product', [ProductController::class, 'index'])->middleware('role:Admin,Karyawan');
Route::get('/product/create', [ProductController::class, 'create'])->middleware('role:Admin,Karyawan');
Route::post('/product', [ProductController::class, 'store'])->middleware('role:Admin,Karyawan');
Route::get('/product/{id}', [ProductController::class, 'edit'])->middleware('role:Admin,Karyawan');
Route::put('/product/{id}', [ProductController::class, 'update'])->middleware('role:Admin,Karyawan');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->middleware('role:Admin,Karyawan');

Route::get('/jenis', [JenisDumpController::class, 'index'])->middleware('role:Admin,Karyawan');
Route::get('/jenis/create', [JenisDumpController::class, 'create'])->middleware('role:Admin,Karyawan');
Route::post('/jenis', [JenisDumpController::class, 'store'])->middleware('role:Admin,Karyawan');
Route::get('/jenis/{id}', [JenisDumpController::class, 'edit'])->middleware('role:Admin,Karyawan');
Route::put('/jenis/{id}', [JenisDumpController::class, 'update'])->middleware('role:Admin,Karyawan');
Route::delete('/jenis/{id}', [JenisDumpController::class, 'destroy'])->middleware('role:Admin,Karyawan');

Route::get('/type', [TypeDumpController::class, 'index'])->middleware('role:Admin,Karyawan');
Route::get('/type/create', [TypeDumpController::class, 'create'])->middleware('role:Admin,Karyawan');
Route::post('/type', [TypeDumpController::class, 'store'])->middleware('role:Admin,Karyawan');
Route::get('/type/{id}', [TypeDumpController::class, 'edit'])->middleware('role:Admin,Karyawan');
Route::put('/type/{id}', [TypeDumpController::class, 'update'])->middleware('role:Admin,Karyawan');
Route::delete('/type/{id}', [TypeDumpController::class, 'destroy'])->middleware('role:Admin,Karyawan');

Route::get('/chassis', [ChassisController::class, 'index'])->middleware('role:Admin,Karyawan');
Route::get('/chassis/create', [ChassisController::class, 'create'])->middleware('role:Admin,Karyawan');
Route::post('/chassis', [ChassisController::class, 'store'])->middleware('role:Admin,Karyawan');
Route::get('/chassis/{id}', [ChassisController::class, 'edit'])->middleware('role:Admin,Karyawan');
Route::put('/chassis/{id}', [ChassisController::class, 'update'])->middleware('role:Admin,Karyawan');
Route::delete('/chassis/{id}', [ChassisController::class, 'destroy'])->middleware('role:Admin,Karyawan');

Route::get('/karyawan', [KaryawanController::class, 'index'])->middleware('role:Admin');
Route::get('/karyawan/create', [KaryawanController::class, 'create'])->middleware('role:Admin');
Route::post('/karyawan', [KaryawanController::class, 'store'])->middleware('role:Admin');
Route::get('/karyawan/{id}', [KaryawanController::class, 'edit'])->middleware('role:Admin');
Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->middleware('role:Admin');
Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->middleware('role:Admin');

Route::get('/pelanggan', [PelangganController::class, 'index'])->middleware('role:Admin');
Route::get('/pelanggan/create', [PelangganController::class, 'create'])->middleware('role:Admin');
Route::post('/pelanggan', [PelangganController::class, 'store'])->middleware('role:Admin');
Route::get('/pelanggan/{id}', [PelangganController::class, 'edit'])->middleware('role:Admin');
Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->middleware('role:Admin');
Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->middleware('role:Admin');

Route::get('/profile', [PelangganController::class, 'profileView'])->middleware('role:Pelanggan');
Route::put('/profile/{id}', [PelangganController::class, 'profile_update'])->middleware('role:Pelanggan');

Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('password.update')->middleware('role:Pelanggan');
Route::put('/profile/{id}', [PelangganController::class, 'profileupdate'])->middleware('role:Pelanggan');

Route::resource('orders', OrderController::class)->middleware('role:Pelanggan');
Route::get('/pesanan', [OrderController::class, 'pesanan'])->name('pesanan')->middleware('role:Pelanggan');

Route::get('/order', [OrderController::class, 'index'])->middleware('role:Admin');
Route::get('/proses', [OrderController::class, 'proses'])->middleware('role:Admin');
Route::get('/selesai', [OrderController::class, 'selesai'])->middleware('role:Admin');
Route::get('/order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');

Route::get('/order-sales', [OrderController::class, 'index_sales'])->middleware('role:Karyawan');
Route::get('/order-sales/{id}', [OrderController::class, 'prosesorder'])->middleware('role:Karyawan');
Route::put('/order-sales/{id}', [OrderController::class, 'updateorder'])->middleware('role:Karyawan');
Route::get('/sales-selesai', [OrderController::class, 'selesai_sales'])->middleware('role:Karyawan');


Route::get('/pembayaran/{order}', [PembayaranController::class, 'index'])->name('pembayaran.index');
Route::post('/pembayaran/{order}', [PembayaranController::class, 'store'])->name('pembayaran.store');

Route::get('/pengirimans-admin', [PengirimanController::class, 'indexAdmin'])->middleware('role:Admin');
Route::get('/pengiriman', [PengirimanController::class, 'indexSales'])->middleware('role:Karyawan');
Route::get('/pengiriman/create', [PengirimanController::class, 'create'])->middleware('role:Karyawan');
Route::post('/pengiriman', [PengirimanController::class, 'store'])->middleware('role:Karyawan');
Route::get('/pengiriman/{id}', [PengirimanController::class, 'edit'])->middleware('role:Karyawan');
Route::put('/pengiriman/{id}', [PengirimanController::class, 'update'])->middleware('role:Karyawan');
Route::delete('/pengiriman/{id}', [pengirimanController::class, 'destroy'])->middleware('role:Karyawan');

Route::get('/order/{id}/cetak', [OrderController::class, 'cetak'])->name('order.cetak');
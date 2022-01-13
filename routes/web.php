<?php

use App\Http\Controllers\KunjanganController;
use App\Http\Controllers\LaporanDinasController;
use App\Http\Controllers\PencatatanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('index');
})->name('index');

Route::get('pencatatan/search', [PencatatanController::class, 'search'])->name('search.pencatatan');
Route::resource('pencatatan', PencatatanController::class);
Route::delete('laporan-dinas/nota', [LaporanDinasController::class, 'deleteNota'])->name('delete-nota');
Route::delete('laporan-dinas/dokumentasi', [LaporanDinasController::class, 'deleteDokumentasi'])->name('delete-dokumentasi');
Route::resource('laporan-dinas', LaporanDinasController::class);
Route::delete('kunjungan/dokumentasi', [KunjanganController::class, 'deleteDokumentasi'])->name('delete-dokumentasi-kunjungan');
Route::resource('kunjungan', KunjanganController::class);

// Route::get('user-management', [UserController::class, 'index'])->name('user.index');
Route::resource('user-management', UserController::class, ['names' => 'user'])->except('show');

Route::get('login', function() {
    return view('login');
})->name('login');
Route::post('login', [UserController::class, 'login']);

Route::get('logout', [UserController::class, 'logout'])->name('logout');
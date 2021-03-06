<?php

use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanDinasController;
use App\Http\Controllers\PerjalananController;
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
Route::get('login', function() {
    return view('login');
})->name('login');
Route::post('login', [UserController::class, 'login']);

Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::get('/', [UserController::class, 'dashboard'])->name('index');
    
    Route::get('pencatatan/search', [PerjalananController::class, 'search'])->name('search.pencatatan');
    Route::resource('perjalanan', PerjalananController::class, ['names' => 'pencatatan'])->except('show');
    Route::delete('laporan-dinas/nota', [LaporanDinasController::class, 'deleteNota'])->name('delete-nota');
    Route::delete('laporan-dinas/dokumentasi', [LaporanDinasController::class, 'deleteDokumentasi'])->name('delete-dokumentasi');
    Route::resource('laporan-dinas', LaporanDinasController::class);
    Route::delete('kunjungan/dokumentasi', [KunjunganController::class, 'deleteDokumentasi'])->name('delete-dokumentasi-kunjungan');
    Route::resource('kunjungan', KunjunganController::class);
    
    Route::get('profile/update', [UserController::class, 'updateProfile'])->name('update.profile');
    Route::post('profile/update', [UserController::class, 'postProfile'])->name('post.profile');
    Route::post('profile/change/password', [UserController::class, 'changePassword'])->name('change.password');
    Route::resource('user-management', UserController::class, ['names' => 'user'])->except('show');

});

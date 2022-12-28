<?php

use App\Http\Controllers\BerkasDigital;
use App\Http\Controllers\BerkasDigitalRanap;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RiwayatInapController;
use App\Models\BerkasDigitalPerawatan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [Dashboard::class, 'index']);
Route::get('/dashboard', [Dashboard::class, 'index']);

//MENU BERKAS RAWAT JALAN
Route::get('/berkas', [BerkasDigital::class, 'index']);
Route::get('berkas.index', [BerkasDigital::class, 'index'])->name('berkas');
Route::post('berkas.file', [BerkasDigital::class, 'file'])->name('files');
Route::post('/select', [BerkasDigital::class, 'getDate']);

//MENU BERKAS RAWAT INAP
Route::get('/berkas_rn', [BerkasDigitalRanap::class, 'index']);
Route::get('berkas_rn.index', [BerkasDigitalRanap::class, 'index'])->name('berkas_rn');
Route::post('berkas_rn.file', [BerkasDigitalRanap::class, 'file'])->name('files_rn');
Route::post('/select_rn', [BerkasDigitalRanap::class, 'getDate']);

//MENU RIWAYAT PERAWATAN
Route::get('/riwayat', [RiwayatController::class, 'index']);
Route::get('riwayat.index', [RiwayatController::class, 'index'])->name('riwayat');
Route::post('riwayat.jalan', [RiwayatController::class, 'jalan'])->name('jalan');
Route::post('riwayat.inap', [RiwayatController::class, 'inap'])->name('inap');
Route::post('riwayat.total', [RiwayatController::class, 'total'])->name('total');
Route::post('/riwayat', [RiwayatController::class, 'getDate']);

//MENU RIWAYAT PERAWATAN
Route::get('/riwayat_rn', [RiwayatInapController::class, 'index']);
Route::get('riwayat_rn.index', [RiwayatInapController::class, 'index'])->name('riwayat_rn');
Route::post('riwayat_rn.jalan', [RiwayatInapController::class, 'jalan'])->name('jalan_rn');
Route::post('riwayat_rn.inap', [RiwayatInapController::class, 'inap'])->name('inap_rn');
Route::post('riwayat_rn.total', [RiwayatInapController::class, 'total'])->name('total_rn');
Route::post('/riwayat_rn', [RiwayatInapController::class, 'getDate']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/reload-captcha', [App\Http\Controllers\Auth\RegisterController::class, 'reloadCaptcha']);
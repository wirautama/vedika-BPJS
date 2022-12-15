<?php

use App\Http\Controllers\BerkasDigital;
use App\Http\Controllers\BerkasDigitalRanap;
use App\Http\Controllers\Dashboard;
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

Route::get('/berkas', [BerkasDigital::class, 'index']);
Route::get('berkas.index', [BerkasDigital::class, 'index'])->name('berkas');
Route::post('berkas.file', [BerkasDigital::class, 'file'])->name('files');
Route::post('/select', [BerkasDigital::class, 'getDate']);

Route::get('/berkas_rn', [BerkasDigitalRanap::class, 'index']);
Route::get('berkas_rn.index', [BerkasDigitalRanap::class, 'index'])->name('berkas_rn');
Route::post('berkas_rn.file', [BerkasDigitalRanap::class, 'file'])->name('files_rn');
Route::post('/select_rn', [BerkasDigitalRanap::class, 'getDate']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

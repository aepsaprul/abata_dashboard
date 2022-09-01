<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\EspkController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function() {
    return redirect()->route('login');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    // Route::get('antrian', [HomeController::class, 'antrian'])->name('home.antrian');
    Route::get('antrian/grafik', [AntrianController::class, 'grafik'])->name('antrian.grafik');
    // Route::get('antrian/{id}/pengunjung', [HomeController::class, 'antrianPengunjung'])->name('home.antrian.pengunjung');
    // Route::get('antrian/{id}/pengunjung_grafik', [HomeController::class, 'antrianGrafik'])->name('home.antrian.pengunjung_grafik');

    // espk
    Route::get('espk/grafik', [EspkController::class, 'grafik'])->name('espk.grafik');
});

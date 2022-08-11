<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('antrian', [HomeController::class, 'antrian'])->name('home.antrian');
    Route::get('antrian/grafik', [HomeController::class, 'antrianGrafik'])->name('home.antrian.grafik');
    Route::get('antrian/{id}/pengunjung', [HomeController::class, 'antrianPengunjung'])->name('home.antrian.pengunjung');
    Route::get('antrian/{id}/pengunjung_grafik', [HomeController::class, 'antrianGrafik'])->name('home.antrian.pengunjung_grafik');
});

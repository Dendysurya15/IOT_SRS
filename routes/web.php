<?php

use App\Http\Controllers\MasterController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

//weather_station route
Route::get('/', [MasterController::class, 'homepage']);
Route::get('/dashboard_ws', [MasterController::class, 'dashboard_ws']);
Route::get('/grafik', [MasterController::class, 'Grafik']);
Route::get('/tabel', [MasterController::class, 'Tabel']);

//water_level route
Route::get('/dashboard_wl', [MasterController::class, 'dashboard_wl'])->name('dashboard_wl');
Route::get('/grafik_wl', [MasterController::class, 'grafik_wl'])->name('grafik_wl');
Route::get('/tabel_wl', [MasterController::class, 'tabel_wl'])->name('tabel_wl');

Route::get('/filltabel', [MasterController::class, 'FilterTabel']);

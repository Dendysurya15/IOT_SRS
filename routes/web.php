<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\LoginController;
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
// Route::get('/', [MasterController::class, 'homepage']);
Route::middleware('checksession')->group(function () {
    Route::get('/dashboard_ws', [MasterController::class, 'dashboard_ws'])->name('dashboard_ws');
    Route::get('/grafik', [MasterController::class, 'Grafik']);
    Route::get('/get_data_24hour', [MasterController::class, 'get_data_24hour'])->name('get_data_24hour');
    Route::get('generateDataGrafik', [MasterController::class, 'generateDataGrafik'])->name('generateDataGrafik');

    Route::get('/tabel', [MasterController::class, 'Tabel']);
    Route::get('month_weather_forecast', [MasterController::class, 'month_weather_forecast'])->name('month_weather_forecast');
    Route::get('getHistoryForecastDay', [MasterController::class, 'getHistoryForecastDay'])->name('getHistoryForecastDay');
    Route::post('getHistoryRainRate', [MasterController::class, 'getHistoryRainRate'])->name('getHistoryRainRate');
    Route::get('getDay/{id}', [MasterController::class, 'getDay'])->name('getDay');

    Route::get('/dashboard_soil', [MasterController::class, 'dashboard_soil'])->name('dashboard_soil');

    Route::post('/storeAktualWS', [MasterController::class, 'storeAktualWS'])->name('aktualws.store');
    Route::get('/editAktualWS/{id}', [MasterController::class, 'editAktualWS'])->name('aktualws.edit');
    Route::delete('/deleteAktualWS/{id}', [MasterController::class, 'deleteAktualWS'])->name('aktualws.destroy');
    Route::get('/aktualws/index', [MasterController::class, 'formAktualWS'])->name('aktualws.index');
    Route::get('/aktualdb', [MasterController::class, 'getAktualDB'])->name('aktual.db');
    Route::get('/compare_weather', [MasterController::class, 'compareWeather'])->name('compare_weather');
    Route::get('/data', [MasterController::class, 'compareWeather'])->name('data');

    //water_level route
    Route::get('/dashboard_wl', [MasterController::class, 'dashboard_wl'])->name('dashboard_wl');
    Route::get('/grafik_wl', [MasterController::class, 'grafik_wl'])->name('grafik_wl');
    Route::get('/get_estate', [MasterController::class, 'get_estate'])->name('get_estate');
    Route::get('/get_data_bulan', [MasterController::class, 'get_data_bulan'])->name('get_data_bulan');
    Route::get('/tabel_wl', [MasterController::class, 'tabel_wl'])->name('tabel_wl');
    Route::post('/get_wl_dashboard', [MasterController::class, 'get_wl_dashboard'])->name('get_wl_dashboard');

    Route::get('/filltabel', [MasterController::class, 'FilterTabel']);

    Route::get('/exportAktual', [MasterController::class, 'exportAktual'])->name('exportAktual');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/update_profile', [HomeController::class, 'updateProfile'])->name('update_profile');

    Route::get('/stationList', [MasterController::class, 'stationList'])->name('stationList');
    Route::post('insertStation', [MasterController::class, 'insertStation'])->name('insertStation');
    Route::post('updateStation', [MasterController::class, 'updateStation'])->name('updateStation');
    Route::post('deleteStation', [MasterController::class, 'deleteStation'])->name('deleteStation');

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('gettabelaws', [MasterController::class, 'gettabelaws'])->name('gettabelaws');
    Route::post('gettablecurahujan', [MasterController::class, 'gettablecurahujan'])->name('gettablecurahujan');
    Route::get('/get-afdlist', [MasterController::class, 'getafdlist']);
    Route::get('/get-datacurahhujan', [MasterController::class, 'datacurahhujan']);
});

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('authenticate');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

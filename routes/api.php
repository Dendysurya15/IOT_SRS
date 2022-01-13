<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//weather
Route::post('/insert_weather_station_list/{rain_cal?}/{loc?}/{lat?}/{lon?}/{desc?}', [MasterController::class, 'store_weather_list']);
Route::post('/insert_weather_station/{idws?}/{datetime?}/{ws?}/{wd?}/{wc?}/{t?}/{h?}/{r?}', [MasterController::class, 'store_weather']);

//water
Route::post('/insert_water_level_list/{location?}/{lat?}/{long?}/{desc?}', [MasterController::class, 'store_water_list']);
Route::post('/insert_water_level/{idwl?}/{datetime?}/{lvl_in?}/{lvl_out?}/{lvl_act?}', [MasterController::class, 'store_water']);

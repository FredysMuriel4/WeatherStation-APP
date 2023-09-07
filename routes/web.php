<?php

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
    return redirect('weather/index');
});

Route::group(['prefix' => 'weather'], function() {
    Route::get('index', [App\Http\Controllers\WeatherController::class, 'index']);
    Route::get('get-city-weather', [App\Http\Controllers\WeatherController::class, 'getCityWeather']);
    Route::get('history', [App\Http\Controllers\WeatherController::class, 'history']);
});

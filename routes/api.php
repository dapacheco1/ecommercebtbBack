<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\RolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/genre',[GenreController::class,"createGenre"]);
Route::get('/genre',[GenreController::class,"getGenres"]);

Route::post('/rol',[RolController::class,"createRol"]);
Route::get('/rol',[RolController::class,"getRols"]);
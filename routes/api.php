<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClothingController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\saleDetailController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
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

########### FOR ADMIN CORE #######
// Route::post('/genre',[GenreController::class,"createGenre"]);
Route::get('/genre',[GenreController::class,"getGenres"]);

// Route::post('/rol',[RolController::class,"createRol"]);
// Route::get('/rol',[RolController::class,"getRols"]);
//Route::get('/categories',[CategoryController::class,"getCategories"]);
Route::get('/sizes',[SizeController::class,"getSizes"]);


######## FOR ADMIN CORE AND CLIENT FRONT-END##########
// Route::post('/person',[PersonController::class,"createPerson"]);
// Route::get('/person',[PersonController::class,"getPersons"]);

Route::post('/clothing',[ClothingController::class,"createClothes"]);
Route::get('/clothing',[ClothingController::class,"getAllClothes"]);
Route::get('/clothing/{category}',[ClothingController::class,"getClothes"]);
Route::delete('/clothing/{id}',[ClothingController::class,"deleteClotheById"]);
Route::put('/clothing',[ClothingController::class,"updateClotheById"]);

Route::post('/users',[UserController::class,"createUser"]);
//Route::get('/users',[UserController::class,"getPersons"]);

Route::post('/users/auth',[UserController::class,"authenticateUser"]);

Route::post('/cart',[CartController::class,"addToCart"]);
Route::delete('/cart/{id}',[CartController::class,"deleteCartByUserId"]);
Route::post('/cart/update',[CartController::class,"updateCart"]);
Route::get('/cart/{id}',[CartController::class,"getCartByUserId"]);

Route::get('/cart/{iduser}/{idcloth}',[CartController::class,"getItemCart"]);

Route::get('/categories',[CategoryController::class,"getCategories"]);
Route::post('/categories',[CategoryController::class,"addCategory"]);
Route::put('/categories',[CategoryController::class,"updateCategory"]);
Route::delete('/categories/{id}',[CategoryController::class,"deleteCategoryById"]);



Route::post('/sell',[SaleController::class,"registerSale"]);
Route::get('/sell/{id}',[SaleController::class,"historySaleByUserId"]);

Route::get('/reports/{top}',[saleDetailController::class,"getMostSell"]);

//Route::post('/update/{cl}/{am}',[SaleController::class,"updateStock"]); only for test purpose

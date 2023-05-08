<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MechanicController;

use App\Http\Controllers\UserRatingController;
use App\Http\Controllers\MechanicRatingController;
use App\Http\Controllers\ServiceRatingController;

use App\Http\Controllers\API\AuthController;

use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    //admin
    Route::resource('services', ServiceController::class)->only(['store', 'update', 'destroy']); //radi store, PUT cudan, delete radi

    Route::resource('mechanics', MechanicController::class)->only(['store', 'update', 'destroy']);  //radi store, PUT cudan, delete radi
    
    Route::resource('users', UserController::class)->only(['destroy']);  //radi
    Route::post('/register', [AuthController::class, 'register']); //radi
  
    Route::resource('ratings', RatingController::class)->only(['store', 'update', 'destroy']); //

    Route::post('/logout', [AuthController::class, 'logout']);  //radi
    
    //ulogovan KORISNIK
    Route::get('/myrating', [UserRatingController::class, 'myrating']); //
    
    Route::resource('users', UserController::class)->only(['update']);  //radi cudno

});

Route::post('/login', [AuthController::class, 'login']); //radi

//javne 
//servis
Route::resource('services', ServiceController::class)->only(['index', 'show']); //radi

//mehanicari
Route::resource('mechanics', MechanicController::class)->only(['index', 'show']); //radi

//ocene
Route::resource('ratings', RatingController::class)->only(['index', 'show']); //radi

//ocene po korisniku, mehanicaru i servisu
Route::get('/users/{id}/ratings', [UserRatingController::class, 'index']); //radi

Route::get('/mechanics/{id}/ratings', [MechanicRatingController::class, 'index']); //radi

Route::get('/services/{id}/ratings', [ServiceRatingController::class, 'index']); //radi

Route::resource('users', UserController::class)->only(['index', 'show']); //

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleriesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/galleries', [GalleriesController::class, 'index']);


Route::middleware('guest')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/create', [GalleriesController::class, 'store']);
    Route::get('/my-galleries', [GalleriesController::class, 'myGalleries']);
    Route::get('/authors/{user_id}', [UserController::class, 'userGalleries']);
    Route::get('/galleries/{gallery}', [GalleriesController::class, 'show']);
    Route::post('/edit/{gallery}', [GalleriesController::class, 'update']);
    Route::post('/delete/{gallery}', [GalleriesController::class, 'destroy']);
});
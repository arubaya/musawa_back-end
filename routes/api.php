<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FacilitiesController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\TestController;
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

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Rooms Data Route
    Route::get('/rooms', [RoomsController::class, 'index']);
    Route::post('/room/create', [RoomsController::class, 'create']);
    Route::post('/room/setfacilitie', [RoomsController::class, 'setRoomFacilitie']);
    Route::put('/room/update/{id}', [RoomsController::class, 'update']);

    // Facilities Data Route
    Route::get('/facilities', [FacilitiesController::class, 'index']);
    Route::post('/facilitie/create', [FacilitiesController::class, 'create']);
    Route::put('/facilities/{roomId}/{facilitieId}', [FacilitiesController::class, 'update']);

    // Users Data Route
    Route::get('/users', [IdentityController::class, 'getAllUsers']);
    Route::get('/user/{id}', [IdentityController::class, 'getUserData']);
    Route::post('/user/update/{id}', [IdentityController::class, 'updateUser']);
    Route::get('/user/identity/{id}', [IdentityController::class, 'getUserById']);
    Route::post('/user/identity/add', [IdentityController::class, 'create']);
    Route::post('/user/identity/update/{id}', [IdentityController::class, 'updateIdentity']);

    // Order Data Route
    Route::get('/order/all', [OrderController::class, 'getOrdersAll']);
    Route::get('/order/user/{id}', [OrderController::class, 'getOrderByUser']);
    Route::get('/order/detail/{orderId}', [OrderController::class, 'getDetailOrder']);
    Route::post('/order/add', [OrderController::class, 'createOrder']);
    Route::put('/order/update/{id}', [OrderController::class, 'updateStatus']);
    Route::delete('/order/delete/{id}', [OrderController::class, 'destroyOrder']);
});

// No Authentication Route
Route::get('/room/detail/{id}', [RoomsController::class, 'getRoomById']);
Route::get('/facilities/room/{id}', [FacilitiesController::class, 'getFacilitiesById']);
Route::get('/check/{id}/{from}/{to}', [OrderController::class, 'checkAvailability']);





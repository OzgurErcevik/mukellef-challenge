<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;

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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/user/{uid}', [UserController::class, 'getUserDetails']);
    Route::post('/user/{uid}/subscription', [SubscriptionController::class, 'subscribe']);
    Route::put('/user/{uid}/subscription/{sid}', [SubscriptionController::class, 'editSubscription']);
    Route::delete('/user/{uid}/subscription/{sid}', [SubscriptionController::class, 'deleteSubscription']);
    Route::post('/user/{uid}/transaction', [TransactionController::class, 'addTransaction']);
});

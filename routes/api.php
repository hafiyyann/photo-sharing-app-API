<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PhotoController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/photos', [PhotoController::class, 'index']);
Route::get('/photos/{id}', [PhotoController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/photos', [PhotoController::class, 'create']);
    Route::put('/photos/{id}', [PhotoController::class, 'update']);
    Route::delete('/photos/{id}', [PhotoController::class, 'destroy']);
    Route::post('/photos/{id}/like', [PhotoController::class, 'likePhoto']);
    Route::post('/photos/{id}/unlike', [PhotoController::class, 'unlikePhoto']);
});

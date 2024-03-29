<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {

        Route::post('/users/org/meta', 'updateOrCreateOrganisationMeta');
        Route::post('/users/change/password', 'updatePassword');
        Route::get('/users/meta', 'getUserMeta');
        Route::post('/users/partial/update', 'userPartialUpdate');
    });
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

<?php

use App\Http\Controllers\AbilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserController;
use App\Models\Ability;
use App\Models\Offer;

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

    Route::controller(ExperienceController::class)->group(function () {
        Route::get('/experiences', 'index');
        Route::get('/experiences/paginate', 'paginateIndex');
        Route::post('/experiences', 'store');
        Route::post('/experiences/{id}', 'update');
        Route::delete('/experiences/{id}', 'destroy');
    });

    Route::controller(AbilityController::class)->group(function () {
        Route::get('/abilities', 'index');
        Route::get('/abilities/paginate', 'paginateIndex');
        Route::post('/abilities', 'store');
        Route::post('/abilities/{id}', 'update');
        Route::delete('/abilities/{id}', 'destroy');
    });
    Route::controller(OfferController::class)->group(function () {
        Route::get('/offers/paginate', 'paginateIndex');
        Route::post('/offers', 'store');
        Route::post('/offers/{id}', 'update');
        Route::delete('/offers/{id}', 'destroy');
    });
});
Route::get('/offers/{id}', [OfferController::class, 'show']);
Route::get('/offers', [OfferController::class, 'index']);
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

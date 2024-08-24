<?php

use App\Http\Controllers\CafeController;
use App\Http\Controllers\MenuController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function() {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    // API route for user
    Route::group(['prefix' => 'user'], function() {
        Route::group(['prefix' => 'manage'], function() {
            Route::post('/all-data', [UserController::class, 'allUser']);
            Route::post('/add-data', [UserController::class, 'addUser']);
            Route::post('/edit-data', [UserController::class, 'editUser']);
            Route::post('/delete-data', [UserController::class, 'destroyUser']);
        });
    });

    Route::group(['prefix' => 'cafe'], function() {
        Route::group(['prefix' => 'manage'], function() {
            Route::post('/all-data', [CafeController::class, 'allCafe']);
            Route::post('/add-data', [CafeController::class, 'addCafe']);
            Route::post('/edit-data', [CafeController::class, 'editCafe']);
            Route::post('/delete-data', [CafeController::class, 'destroyCafe']);
        });

        Route::group(['prefix' => 'menu'], function() {
            Route::post('/all-data', [MenuController::class, 'allMenu']);
            Route::post('/add-data', [MenuController::class, 'addMenu']);
            Route::post('/edit-data', [MenuController::class, 'editMenu']);
            Route::post('/delete-data', [MenuController::class, 'destroyMenu']);
        });
    });

    // API auth route for superadmin
    Route::post('/logout', [UserController::class, 'logout']);
    // Route::post('/reset-password', [AuthController::class, 'reset']);
    // Route::post('/change-password', [AuthController::class, 'change']);
    // Route::post('/active-deactive', [AuthController::class, 'activeDeactive']);
});
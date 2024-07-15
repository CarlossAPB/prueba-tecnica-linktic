<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function () {
    Route::post("register", "register");
    Route::post("login", "login");
});

Route::group(
    ['middleware' => 'auth:api'],
    function () {
        Route::prefix("tasks")->controller(TaskController::class)->group(function () {
            Route::get("/", "index");
            Route::get("/by/status/{status}", "byStatus");
            Route::get("/by/due-date-range/{dateStart}/{dateEnd}", "byDueDateRange");
            Route::get("/{id}", "show");
            Route::post("/", "store");
            Route::put("/{id}", "update");
            Route::delete("/{id}", "destroy");
        });
    }
);

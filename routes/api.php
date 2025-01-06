<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\MonitoringController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("login", [UserController::class, "login"]);
Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::apiResource("team", TeamController::class);
    Route::apiResource("role", RoleController::class);

    Route::post("user/tag_system", [UserController::class, "tag_system"]);
    Route::patch("user/archived/{id}", [UserController::class, "destroy"]);
    Route::apiResource("user", UserController::class);
    Route::apiResource("project", ProjectController::class);
    Route::apiResource("monitoring", MonitoringController::class);
});

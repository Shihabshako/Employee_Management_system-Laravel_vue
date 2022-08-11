<?php

use App\Http\Controllers\ApplyLeaveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeOfLeaveController;

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

Route::post("/login", [LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post("/logout", [LoginController::class, 'logout']);

    Route::post("/user-details", [UserController::class, "userDetailsShow"]);
    Route::put("/update-user/{id}", [UserController::class, "updateUser"]);
    Route::post("/change-password", [UserController::class, "changePassword"]);
    Route::get("/employees", [UserController::class, "getAllEmployees"]);
    Route::get("/employees/{id}", [UserController::class, "getSingleEmployees"]);
    Route::delete("/employees/{id}", [UserController::class, "destroy"]);
    Route::get("/cards-count", [UserController::class, "cardsValueCount"]);
    Route::get("/dropdown-values", [UserController::class, "allDropdownValues"]);

    Route::apiResource("/type-of-leaves", TypeOfLeaveController::class);
    Route::apiResource("/apply-leaves", ApplyLeaveController::class);
    Route::post("/apply-leaves-per-manager", [ApplyLeaveController::class, "applicationPerManager"]);
    Route::get("/approve-application-by-manager/{id}", [ApplyLeaveController::class, "approveApplicationByManager"]);
    Route::get("/decline-application-by-manager/{id}", [ApplyLeaveController::class, "declineApplicationByManager"]);
    Route::get("/approve-application-by-administration/{id}", [ApplyLeaveController::class, "approveApplicationByAdministration"]);
    Route::get("/decline-application-by-administration/{id}", [ApplyLeaveController::class, "declineApplicationByAdministration"]);

    Route::get("/notification-list/{id}",  [NotificationController::class, "notificationPerUser"]);
    Route::get("/mark-notification-read/{id}",  [NotificationController::class, "notificationMarkRead"]);
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LeaveApplicationController;

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
Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);
Route::get('/regEmail', [AuthController::class, 'regEmail']);

Route::group(['prefix' => 'admin','middleware' => 'auth:sanctum'], function() {
    Route::get('/getUser', [LoginController::class, 'getUser']);
    Route::post('/logout', [LoginController::class, 'logout']);
    // Admin
    // Personnel
    Route::get('/getPersonnel', [AdminController::class, 'getPersonnel']);
    Route::post('/storePersonnel', [AdminController::class, 'storePersonnel']);
    Route::post('/uploadPersonnelImage', [AdminController::class, 'uploadPersonnelImage']);
    Route::post('/deletePeronnelImage', [AdminController::class, 'deletePeronnelImage']);
    Route::get('/getOnePersonnel/{id}', [AdminController::class, 'getOnePersonnel']);
    Route::post('/updatePersonnel', [AdminController::class, 'updatePersonnel']);
    Route::post('/deletePersonnel', [AdminController::class, 'deletePersonnel']);
    Route::post('/updatePersonnelAccountPassword', [AdminController::class, 'updatePersonnelAccountPassword']);

    // Leave Application
    Route::get('/getLeaveApplications', [LeaveApplicationController::class, 'getLeaveApplications']);
    Route::post('/storeLeaveApplication', [LeaveApplicationController::class, 'storeLeaveApplication']);
    Route::post('/acceptLeaveApplication', [LeaveApplicationController::class, 'acceptLeaveApplication']);
    Route::post('/acceptLeaveApplication', [LeaveApplicationController::class, 'acceptLeaveApplication']);

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

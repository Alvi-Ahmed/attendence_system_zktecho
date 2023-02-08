<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RecordController;

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
Route::apiResource('record', RecordController::class);
Route::apiResource('user', UserController::class);
Route::get('users/{id}',[UserController::class,'userid']);
Route::get('records/{user_id}',[RecordController::class,'recordget']);
Route::get('lrecords/{user_id}',[RecordController::class,'leavereport']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EquipmentController;
use App\Http\Controllers\API\EquipmentTypeController;
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
Route::post('/user/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/equipment',[EquipmentController::class,'index']);
    Route::post('/equipment',[EquipmentController::class,'store']);
    Route::get('/equipment/{id}',[EquipmentController::class,'show']);
    Route::put('/equipment/{id}',[EquipmentController::class,'update']);
    Route::delete('/equipment/{id}',[EquipmentController::class,'destroy']);
    Route::get('/equipment-type',[EquipmentTypeController::class,'index']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


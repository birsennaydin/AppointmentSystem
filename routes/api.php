<?php

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
Route::group(["namespace"=>"api"], function (){
    Route::get('/working_hours/{date?}', [App\Http\Controllers\api\IndexController::class, 'getHours']);
    Route::post('/appointment_store', [App\Http\Controllers\api\IndexController::class, 'appointmentStore']);
    Route::get('/appointment_store', [App\Http\Controllers\api\IndexController::class, 'appointmentStore']);

    Route::group(["namespace"=>"admin", "prefix"=>"admin"], function (){
        Route::get('/all', [App\Http\Controllers\api\admin\IndexController::class, 'all']);
        Route::get('/reject_list', [App\Http\Controllers\api\admin\IndexController::class, 'getRejectList']);
        Route::post('/process', [App\Http\Controllers\api\admin\IndexController::class, 'process']);
        Route::get('/list', [App\Http\Controllers\api\admin\IndexController::class, 'getList']);
        Route::get('/today_list', [App\Http\Controllers\api\admin\IndexController::class, 'getTodayList']);
        Route::get('/waiting_list', [App\Http\Controllers\api\admin\IndexController::class, 'getWaitingList']);
        Route::get('/last_list', [App\Http\Controllers\api\admin\IndexController::class, 'getLastList']);
    });
});

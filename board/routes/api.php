<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiListController;

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

Route::get('/list/{id}', [ApiListController::class,'getlist']);
Route::post('/list',[ApiListController::class, 'postlist']);
Route::put('/list/{id}',[ApiListController::class, 'putlist']);
Route::delete('/list/{id}',[ApiListController::class, 'deletelist']);
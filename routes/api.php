<?php

use App\Http\Controllers\TransactionController;
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

// Route::get('categories',
//     [\App\Http\Controllers\Api\CategoryControlller::class , 'index']
// );
// Route::get('categories/{category}',
//     [\App\Http\Controllers\Api\CategoryControlller::class , 'show']
// );

/*
    ** include only 5 insrated of 7 methods
*/ 
Route::apiResource('categories', \App\Http\Controllers\Api\CategoryControlller::class);
Route::apiResource('transactions', \App\Http\Controllers\Api\TraController::class );

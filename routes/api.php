<?php

use App\Http\Controllers\TransactionController;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException as ValidationValidationException;

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

// Route::middleware('auth:sanctum')->group(function(){
    
//     /*
//         ** include only 5 insrated of 7 methods
//     */ 
//     Route::apiResource('categories', \App\Http\Controllers\Api\CategoryControlller::class);
//     Route::apiResource('transactions', \App\Http\Controllers\Api\TraController::class );
// });

Route::group(['middleware'=>'auth:sanctum'] , function(){
    
    /*
        ** include only 5 insrated of 7 methods
    */ 
    Route::apiResource('categories', \App\Http\Controllers\Api\CategoryControlller::class);
    Route::apiResource('transactions', \App\Http\Controllers\Api\TraController::class );
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

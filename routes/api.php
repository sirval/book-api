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

Route::prefix('v1')->group(function(){
    Route::apiResources(
        ['book' => App\Http\Controllers\v1\BookController::class]
    );
    Route::post('store-user', [App\Http\Controllers\v1\BookController::class, 'storeUser']);
    Route::post('send-user-invite', [App\Http\Controllers\v1\BookController::class, 'sendInvite']);
});
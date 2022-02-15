<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\TransactionController;
use App\Interfaces\ICardAuth;
use App\Utils\TransferMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


/**
 * routes for user account informations
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'card'], function () {
    Route::post('/store', [CardController::class, 'store']);
    Route::get('/show', [CardController::class, 'show']);
});

/**
 * routes for taransfer money between two accounts
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'transaction'], function () {
    Route::post('create', [TransactionController::class, 'create']);
    Route::get('show', [TransactionController::class, 'show']);

});

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

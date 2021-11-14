<?php

use App\Http\Controllers\API\LoanController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RepaymentController;
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
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/loans', [LoanController::class, 'index']);
    Route::post('/loans', [LoanController::class, 'store']);
    Route::get('/repayments', [RepaymentController::class, 'index']);
    Route::post('/repayments', [RepaymentController::class, 'store']);
});

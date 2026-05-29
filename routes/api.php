<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RekonPajakController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function () {
    return response()->json([
        'message' => 'API PDRD Integrasi Data'
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {
    Route::get('/rekon-pajak', [RekonPajakController::class, 'index']);
    Route::post('/rekon-pajak', [RekonPajakController::class, 'store']);
    Route::get('/rekon-pajak/filter-by-date', [RekonPajakController::class, 'filterByDate']);
    Route::get('/rekon-pajak/filter-by-jenis-pajak', [RekonPajakController::class, 'filterByJenisPajak']);
});

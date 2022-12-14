<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\Orders;
use App\Http\Controllers\API\Vouchers;
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
Route::get('vouchers/used', [Vouchers::class, 'usedVouchers']);
Route::get('vouchers/active', [Vouchers::class, 'activeVouchers']);
Route::get('vouchers/expired', [Vouchers::class, 'expiredVouchers']);
Route::apiResource('vouchers', Vouchers::class);

Route::apiResource('orders', Orders::class);
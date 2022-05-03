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

Route::get('products', [\App\Http\Controllers\ProductController::class, 'getListOfAvailableProducts'])->name('products');

Route::post('scan-start', [\App\Http\Controllers\ScanController::class, 'sessionStart'])->name('scans.start-session');
Route::post('scan-product', [\App\Http\Controllers\ScanController::class, 'scanProduct'])->name('scans.scan-product');
Route::post('scan-end', [\App\Http\Controllers\ScanController::class, 'sessionEnd'])->name('scans.end-session');
Route::get('scan-details', [\App\Http\Controllers\ScanController::class, 'sessionDetails'])->name('scans.details');

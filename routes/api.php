<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

# Create user
Route::post('/user/new', [ApiController::class, 'createUser']);

# Create service order
Route::post('/service-order/new', [ApiController::class, 'createServiceOrder']);

# Get service orders
Route::get('/service-orders', [ApiController::class, 'getServiceOrders']);
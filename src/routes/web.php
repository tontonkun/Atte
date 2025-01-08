<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'firstHomePage']);
    Route::post('/start_work', [AuthController::class, 'afterStartWork']);
    Route::post('/end_work', [AuthController::class, 'afterEndWork']);
    Route::post('/start_rest', [AuthController::class, 'afterStartRest']);
    Route::post('/end_rest', [AuthController::class, 'afterEndRest']);
});

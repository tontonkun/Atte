<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TimeRecordController;
use App\Http\Controllers\UserListController;

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
    Route::get('/time_record', [TimeRecordController::class, 'timeRecord']);
    Route::get('/time_record_forOneUser', [TimeRecordController::class, 'timeRecord_forOneUser']);

    // 昨日と明日のルートを追加
    Route::get('/time_record_yesterday', [TimeRecordController::class, 'yesterday']);
    Route::get('/time_record_tomorrow', [TimeRecordController::class, 'tomorrow']);

    // ユーザーリスト関連のルート
    Route::get('/user_list', [UserListController::class, 'UserList']);
});



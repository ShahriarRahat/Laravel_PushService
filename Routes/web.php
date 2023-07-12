<?php

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

use Illuminate\Support\Facades\Route;
use Modules\PushService\Http\Controllers\PushServiceController;

Route::group(['prefix' => 'pushservice', 'middleware' => ['auth:web', 'IsAdmin']], function () {
    Route::get('/',             [PushServiceController::class, 'index'])->name('pushService.index');
    Route::get('/create',       [PushServiceController::class, 'create'])->name('pushService.create');
    Route::post('/',            [PushServiceController::class, 'store'])->name('pushService.store');
    Route::post('/delete',      [PushServiceController::class, 'destroy'])->name('pushService.delete');
});

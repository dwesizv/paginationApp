<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('handmade',  [App\Http\Controllers\YateController::class, 'handmade'])->name('yate.handmade');
Route::get('oldyate',   [App\Http\Controllers\YateController::class, 'oldyate'])->name('yate.oldyate');
Route::get('yate',      [App\Http\Controllers\YateController::class, 'index'])->name('yate.index');
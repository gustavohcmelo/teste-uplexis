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
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('carros')->group(function(){
    Route::get('/', [App\Http\Controllers\CarrosController::class, 'index'])->name('carros.index');
    Route::get('/store', [App\Http\Controllers\CarrosController::class, 'store'])->name('carros.store');
    Route::delete('/destroy/{carro}', [App\Http\Controllers\CarrosController::class, 'destroy'])->name('carros.destroy');
});

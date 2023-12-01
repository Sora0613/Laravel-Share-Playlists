<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('top');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/index', [App\Http\Controllers\PlaylistsController::class, 'index'])->name('index');

Route::get('/search', [App\Http\Controllers\PlaylistsController::class, 'search'])->name('search');

Route::post('/search', [App\Http\Controllers\PlaylistsController::class, 'search'])->name('search.do');

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

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\PlaylistsController::class, 'index'])->name('index'); //表示

    Route::get('/search', [App\Http\Controllers\AppleController::class, 'search'])->name('search'); //表示

    Route::post('/search', [App\Http\Controllers\AppleController::class, 'search'])->name('search.do');

    Route::get('/spotify/auth', [App\Http\Controllers\SpotifyController::class, 'spotify_auth'])->name('spotify.auth'); //表示

    Route::get('/spotify/callback', [App\Http\Controllers\SpotifyController::class, 'spotify_callback'])->name('spotify.callback');

    Route::get('/spotify/create/', [App\Http\Controllers\SpotifyController::class, 'spotify_create'])->name('spotify.create'); //表示

    Route::post('/spotify/create/', [App\Http\Controllers\SpotifyController::class, 'spotify_create'])->name('spotify.playlist.create');

});

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

    /*通常プレイリスト*/

    Route::get('/home', [App\Http\Controllers\PlaylistsController::class, 'index'])->name('index'); //表示
    Route::get('/playlist/create', [App\Http\Controllers\PlaylistsController::class, 'playlistCreate'])->name('playlist.create'); //表示
    Route::post('/playlist/create', [App\Http\Controllers\PlaylistsController::class, 'playlistStore'])->name('playlist.store'); //登録

    /* iTunesここから */

    Route::get('/apple/search', [App\Http\Controllers\AppleController::class, 'search'])->name('search'); //表示

    Route::post('/apple/search', [App\Http\Controllers\AppleController::class, 'search'])->name('search.do');

    /* iTunesここまで */

    /* Spotifyここから */

    Route::get('/spotify/auth', [App\Http\Controllers\SpotifyController::class, 'spotify_auth'])->name('spotify.auth'); //表示

    Route::get('/spotify/callback', [App\Http\Controllers\SpotifyController::class, 'spotify_callback'])->name('spotify.callback');

    Route::get('/spotify/search/', [App\Http\Controllers\SpotifyController::class, 'spotify_search'])->name('spotify.search'); //表示

    Route::post('/spotify/search/', [App\Http\Controllers\SpotifyController::class, 'spotify_search'])->name('spotify.playlist.search');

    /* Spotifyここまで */

});

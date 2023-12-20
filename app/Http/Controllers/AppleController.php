<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Facades\MusicService;
use Illuminate\Support\Facades\Auth;

class AppleController extends Controller
{
    /* iTunes APIから楽曲を検索する */
    public function search(Request $request)
    {
        if ($request->has('songs_keywords')) {
            $keyword = $request->input('songs_keywords');
            $songs = MusicService::searchFromApple($keyword);

            $playlists = Playlist::where('user_id', Auth::user()->id)->get();

            return view('itunes.search', [
                'songs' => $songs,
                'playlists' => $playlists,
            ]);
        }
        return view('itunes.search');
    }

    
}

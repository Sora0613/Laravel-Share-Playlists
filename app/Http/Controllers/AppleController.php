<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\MusicService;

class AppleController extends Controller
{
    /* iTunes APIから楽曲を検索する */
    public function search(Request $request)
    {
        if ($request->has('songs-keywords')) {
            $keyword = $request->input('songs-keywords');
            $songs = MusicService::searchFromApple($keyword);

            return view('itunes.search', [
                'songs' => $songs,
            ]);
        }
        return view('itunes.search');
    }
}

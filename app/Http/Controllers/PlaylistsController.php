<?php

namespace App\Http\Controllers;

use App\Facades\MusicService;
use App\Models\Playlist;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class PlaylistsController extends Controller
{
    public function index()
    {
        return view('playlists.index');
    }

    public function playlistCreate()
    {
        return view('playlists.create');
    }

    public function playlistStore(Request $request)
    {

        $request->validate([
            'playlist_name' => 'required|max:255',
            'playlist_description' => 'required|max:255',
        ]);

        Playlist::create([
            'playlist_name' => $request->input('playlist_name'),
            'playlist_description' => $request->input('playlist_description'),
            'user_id' => Auth::user()->id,
            'is_private' => $request->input('is_private') ? true : false,
        ]);


        return back()->with('message', 'プレイリストを作成しました。');
    }
}

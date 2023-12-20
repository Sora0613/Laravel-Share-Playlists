<?php

namespace App\Http\Controllers;

use App\Facades\MusicService;
use App\Models\Playlist;
use App\Models\Song;
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
        $playlists = Playlist::where('user_id', Auth::user()->id)->get();

        if (count($playlists) > 0) {
            return view('playlists.create', compact('playlists'));
        }

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

        $playlists = Playlist::where('user_id', Auth::user()->id)->get();

        return view('playlists.create', compact('playlists'));
    }

    public function playlistShow($id)
    {
        /* プレイリストに登録されている曲を取得。
        is_privateがonなら、自分のプレイリスト以外は表示しない。
        playlistがなければ存在しない旨を返す。*/

        $playlist = Playlist::find($id);

        if($playlist === null) {
            $message = 'このプレイリストは存在しません。';
            return view('playlists.show', compact('message'));
        }

        //曲を取得
        $songs = Song::where('playlist_id', $id)->get();

        if ($playlist->is_private) {

            if(isset(Auth::user()->id) && $playlist->user_id === Auth::user()->id) {
                $user = User::find($playlist->user_id);
                return view('playlists.show', compact('playlist', 'user', 'songs'));
            }

            $message = 'このプレイリストは非公開です。';
            return view('playlists.show', compact('message'));
        }

        $user = User::find($playlist->user_id);
        return view('playlists.show', compact('playlist', 'user', 'songs'));
    }

    public function playlistSongAdd(Request $request)
    {
        $encodedSong = $request->input('song');
        $playlist_id = $request->playlist;

        // デコード
        $song = json_decode(base64_decode($encodedSong), true);

        Song::create([
            'song_name' => $song['trackName'],
            'artist_name' => $song['artistName'],
            'album_name' => $song['collectionName'],
            'artwork_url' => $song['artworkUrl100'],
            'playlist_id' => $playlist_id,
        ]);

        $message = '曲を追加しました。';

        return back()->with('message', $message);
    }

    public function playlistSongDelete(Request $request, $song_id)
    {
        $song = Song::find($song_id);
        $song->delete();

        $message = '曲を削除しました。';

        return back()->with('message', $message);
    }

    public function showAllPlaylists()
    {
        $playlists = Playlist::where('user_id', Auth::user()->id)->get();

        return view('playlists.lists', compact('playlists'));
    }
}

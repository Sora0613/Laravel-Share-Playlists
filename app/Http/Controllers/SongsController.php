<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\Request;

class SongsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $encodedSong = $request->input('song');
        $playlist_id = $request->playlist;

        $song = json_decode(base64_decode($encodedSong), true);

        //get playlist name from playlist_id
        $playlist_name = Playlist::find($playlist_id)->playlist_name;
        $song_name = $song['trackName'];

        Song::create([
            'song_name' => $song['trackName'],
            'artist_name' => $song['artistName'],
            'album_name' => $song['collectionName'],
            'artwork_url' => $song['artworkUrl100'],
            'playlist_id' => $playlist_id,
        ]);

        $message = ('【' . $playlist_name . '】に【' . $song_name . '】を追加しました。');

        return back()->with('message', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $song = Song::find($id);
        $song->delete();

        $message = '【' . $song->song_name . '】をプレイリストから削除しました。';

        return back()->with('message', $message);
    }
}

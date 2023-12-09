<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Facades\MusicService;

class SpotifyController extends Controller
{
    /* Spotify APIから楽曲を検索する */
    public function spotify_search(Request $request)
    {
        if($request->has('playlist-url')) {
            $user = User::where('id', Auth::id())->first();
            if(empty($user)){
                return redirect('/spotify/auth');
            }

            $spotify_playlist_url = $request->input('playlist-url');
            $expiresAt = $user->spotify_expires_at;

            $spotify_playlist_id = MusicService::getPlaylistId($spotify_playlist_url);


            if($expiresAt < Carbon::now()){
                [$access_token, $expires_in] = MusicService::refreshAccessToken($user->spotify_refresh_token);
                $expiresAt = Carbon::now()->addSeconds($expires_in);
                User::where('id',Auth::id())->update([
                    'spotify_access_token' => $access_token,
                    'spotify_expires_at' => $expiresAt,
                ]);
            }else{
                $access_token = $user->spotify_access_token;
            }


            if (isset($spotify_playlist_id)) {
                $api_url = "https://api.spotify.com/v1/playlists/$spotify_playlist_id/tracks";

                $client = new Client();

                try {
                    $response = $client->request('GET', $api_url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $access_token,
                            'Content-Type' => 'application/json',
                        ]
                    ]);
                    $track_data = json_decode($response->getBody(), true);

                    if(isset($track_data['items']) && is_array($track_data['items'])) {
                        $track_data = $track_data['items'];

                        $request->validate([
                            'playlist_name' => 'required|max:255',
                            'playlist_description' => 'required|max:255',
                        ]);

                        $playlist = Playlist::create([
                            'playlist_name' => $request->input('playlist_name'),
                            'playlist_description' => $request->input('playlist_description'),
                            'user_id' => Auth::user()->id,
                            'is_private' => $request->input('is_private') ? true : false,
                        ]);

                        foreach ($track_data as $song) {
                            $artwork = $song['track']['album']['images'][0]['url'];
                            $song_name = $song['track']['name'];
                            $artist_name = $song['track']['artists'][0]['name'];
                            $album_name = $song['track']['album']['name'];

                            Song::create([
                                'song_name' => $song_name,
                                'artist_name' => $artist_name,
                                'album_name' => $album_name,
                                'artwork_url' => $artwork,
                                'playlist_id' => $playlist->id,
                            ]);
                        }
                        $message = "プレイリストを作成しました。\n";

                        return view('spotify.spotify_search', [
                            'message' => $message,
                        ]);
                    }

                    $message = "プレイリストの取得に失敗しました。\n";

                    return view('spotify.spotify_search', [
                        'message' => $message,
                    ]);


                } catch (GuzzleException $e) {
                    abort(500, $e->getMessage());
                }
            }
        }
        return view('spotify.spotify_search');
    }

    /* SpotifyのAPIに関する認証処理 ここから */
    public function spotify_auth()
    {
        $state = bin2hex(random_bytes(16));
        $authorization_url = MusicService::GenerateSpotifyAuthUrl($state);
        return view('spotify.spotify_auth', [
            'authorization_url' => $authorization_url,
        ]);
    }

    public function spotify_callback(Request $request)
    {
        $state = $request->input('state');
        $code = $request->input('code');

        $client_id = config('spotify_keys.spotify_client_id');
        $client_secret = config('spotify_keys.spotify_client_secret');
        $redirect_uri = config('spotify_keys.spotify_redirect_url');


        if ($state !== null) {
            // アクセストークンを取得するためのリクエスト
            $token_url = 'https://accounts.spotify.com/api/token';

            $client = new Client();
            $response = $client->request('POST', $token_url, [
                'form_params' => [
                    'code' => $code,
                    'redirect_uri' => $redirect_uri,
                    'grant_type' => 'authorization_code',
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode("$client_id:$client_secret"),
                ],
            ]);

            if ($response !== false) {
                $json = $response->getBody();
                $token_data = json_decode($json, true);

                $access_token = $token_data['access_token'];
                $refresh_token = $token_data['refresh_token'];
                $expires_in = $token_data['expires_in'];

                User::where('id',Auth::id())->update([
                    'spotify_access_token' => $access_token,
                    'spotify_refresh_token' => $refresh_token,
                    'spotify_expires_at' => Carbon::now()->addSeconds($expires_in),
                    'spotify_login' => true,
                ]);

                return redirect('/home');
            }

            $message = "アクセストークンの取得に失敗しました。\n";
            return view('spotify.spotify_callback', [
                'message' => $message,
            ]);
        }

        $message = "stateが存在しませんでした。\n";
        return view('spotify.spotify_callback', [
            'message' => $message,
        ]);
    }
    /* SpotifyのAPIに関する認証処理 ここまで */
}

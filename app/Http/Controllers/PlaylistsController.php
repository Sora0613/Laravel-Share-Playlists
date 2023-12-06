<?php

namespace App\Http\Controllers;

use App\Facades\MusicService;
use App\Models\User;
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

    public function search(Request $request)
    {
        if ($request->has('songs-keywords')) {
            $keyword = $request->input('songs-keywords');
            $songs = MusicService::searchFromApple($keyword);

            return view('playlists.search', [
                'songs' => $songs,
            ]);
        }

        return view('playlists.search');

    }

    public function spotify_auth()
    {
        $state = bin2hex(random_bytes(16));
        $authorization_url = MusicService::GenerateSpotifyAuthUrl($state);
        return view('playlists.spotify_auth', [
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

            $client = new \GuzzleHttp\Client();
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
            return view('playlists.spotify_callback', [
                'message' => $message,
            ]);
        }

        $message = "stateが存在しませんでした。\n";
        return view('playlists.spotify_callback', [
            'message' => $message,
        ]);
    }

    public function spotify_create(Request $request)
    {
        if($request->has('playlist-url')) {
            $user = User::where('id', Auth::id())->first();

            $playlist_url = $request->input('playlist-url');
            $expiresAt = $user->spotify_expires_at;

            $playlist_id = MusicService::getPlaylistId($playlist_url);


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


            if (isset($playlist_id)) {

                $api_url = "https://api.spotify.com/v1/playlists/{$playlist_id}/tracks";

                // Guzzleを使ってSpotify APIにリクエストを送る
                $client = new \GuzzleHttp\Client();

                //try {
                    // Send a GET request to the Spotify API
                    $response = $client->request('GET', $api_url, [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $access_token,
                            'Content-Type' => 'application/json',
                        ]
                    ]);

                    // Parse the response body as JSON
                    $track_data = json_decode($response->getBody(), true);

                    return view('playlists.spotify_create', [
                        'track_data' => $track_data,
                    ]);
                //} catch (\GuzzleHttp\Exception\GuzzleException $e) {
                    //abort(500, $e->getMessage());
                //}
            }
        }
        return view('playlists.spotify_create');
    }
}

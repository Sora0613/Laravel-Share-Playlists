<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
            $songs = $this->searchMusicFromItunes($keyword);

            return view('playlists.search', [
                'songs' => $songs,
            ]);
        }

        return view('playlists.search');

    }

    private function searchMusicFromItunes($keyword){
        $api_endpoint = "https://itunes.apple.com/search";
        $term = $keyword;
        $params = [
            'term' => $term,
            'country' => 'JP', // 検索対象の国を指定
            'media' => 'music', // 検索対象のメディア種別を指定 (allはすべて)
            'entity' => 'song', // 検索対象の種別を指定 (allはすべて)
        ];

        $query_string = http_build_query($params);
        $request_url = "{$api_endpoint}?{$query_string}";

        $response = file_get_contents($request_url);

        if ($response !== false) {
            $data = json_decode($response, true);

            return $data['results']; //songsの配列を返す
        }

        return [];
    }

    //* --- Spotify API処理 --- *//

    private function MakeAuthorzationUrl($state)
    {
        $client_id = config('spotify_keys.spotify_client_id');
        $redirect_uri = config('spotify_keys.spotify_redirect_url');
        $scope = "user-read-private user-read-email"; // 必要なスコープをスペースで区切って指定

        $authorization_url = "https://accounts.spotify.com/authorize";
        $authorization_params = [
            'response_type' => 'code',
            'client_id' => $client_id,
            'scope' => $scope,
            'redirect_uri' => $redirect_uri,
            'state' => $state
        ];

        $authorization_url .= '?' . http_build_query($authorization_params);

        // 認可ページのURLを返す
        return $authorization_url;
    }


    public function spotify_auth()
    {
        $state = bin2hex(random_bytes(16));
        $authorization_url = $this->MakeAuthorzationUrl($state);
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

                /*return view('playlists.spotify_callback', [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token,
                    'expires_in' => $expires_in,
                ]);*/

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
            $access_token = $user->spotify_access_token;
            $expiresAt = $user->spotify_access_token_expires_at;

            $playlist_id = $this->getPlaylistId($playlist_url);

            if(Carbon::now()->gte($expiresAt)){
                list($access_token, $expiresIn) = $this->refreshAccessToken($user->spotify_refresh_token);
                $user->spotify_access_token = $access_token;
                $user->spotify_access_token_expires_at = Carbon::now()->addSeconds($expiresIn);
            }

            if (isset($playlist_id)) {

                $api_url = "https://api.spotify.com/v1/playlists/{$playlist_id}/tracks";

                // ヘッダー設定
                $headers = [
                    'Authorization: Bearer ' . $access_token,
                    'Content-Type: application/json',
                ];

                // APIリクエスト
                $options = [
                    'http' => [
                        'header' => $headers,
                        'method' => 'GET',
                    ],
                ];

                $context = stream_context_create($options);
                $response = file_get_contents($api_url, false, $context);

                if ($response !== false) {
                    $json = $response;
                    $track_data = json_decode($json, true);

                    return view('playlists.spotify_create', [
                        'access_token' => $access_token,
                        'user' => $user,
                        'track_data' => $track_data,
                    ]);
                }
            }
        }
        return view('playlists.spotify_create');
    }

    private function getPlaylistId($playlist_url){
        preg_match('/playlist\/([a-zA-Z0-9]+)/', $playlist_url, $result);
        if(isset($result[1])){
            return $result[1];
        }
        return null;
    }

    private function refreshAccessToken($refreshToken){
            // アクセストークンが有効期限切れの場合はリフレッシュトークンを使用して新しいアクセストークンを取得
            $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => 'YOUR_CLIENT_ID',
                'client_secret' => 'YOUR_CLIENT_SECRET',
            ]);

            // 新しいアクセストークンと有効期限を取得
            $newAccessToken = $response->json('access_token');
            $expiresIn = $response->json('expires_in');

            return [$newAccessToken, $expiresIn];
    }
}




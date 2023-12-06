<?php
namespace App\Http\Components;

use Illuminate\Support\Facades\Http;

class MusicService
{

    // Test Method
    public function HelloWorld()
    {
        return 'Hello World!';
    }

    // iTunes APIから楽曲を検索する
    public static function searchFromApple($keyword){
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

    // Spotify APIから認証URLを発行する
    public function GenerateSpotifyAuthUrl($state)
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

    public function getPlaylistId($playlist_url){
        preg_match('/playlist\/([a-zA-Z0-9]+)/', $playlist_url, $result);
        if(isset($result[1])){
            return $result[1];
        }
        return null;
    }

    public function refreshAccessToken($refreshToken){
        // アクセストークンが有効期限切れの場合はリフレッシュトークンを使用して新しいアクセストークンを取得
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => config('spotify_keys.spotify_client_id'),
            'client_secret' => config('spotify_keys.spotify_client_secret'),
        ]);

        // 新しいアクセストークンと有効期限を取得
        $newAccessToken = $response->json('access_token');
        $expiresIn = $response->json('expires_in');

        return [$newAccessToken, $expiresIn];
    }

}

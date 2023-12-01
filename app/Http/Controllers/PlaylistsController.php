<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaylistsController extends Controller
{
    public function index()
    {
        return view('playlists.index');
    }

    public function search(Request $request)
    {
        if($request->has('songs-keywords'))
        {
            $keyword = $request->input('songs-keywords');

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

                $songs = $data['results'];
            }

            return view('playlists.search', [
                'songs' => $songs,
            ]);

        }

        return view('playlists.search');

    }

    //* --- Spotify API処理 --- *//

    private function MakeAuthorzationUrl()
    {
        $client_id = "c05b74610e66445395fe5314fe52ba8b";
        $redirect_uri = "http://localhost:8080/callback";
        $scope = "user-read-private user-read-email"; // 必要なスコープをスペースで区切って指定

        $authorization_url = "https://accounts.spotify.com/authorize";
        $authorization_params = [
            'response_type' => 'code',
            'client_id' => $client_id,
            'scope' => $scope,
            'redirect_uri' => $redirect_uri,
        ];

        $authorization_url .= '?' . http_build_query($authorization_params);

        // 認可ページのURLを返す
        return $authorization_url;
    }

    public function spotify()
    {
        return view('playlists.spotify');
    }

}

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Playlists</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<div class="container">
    <h1>Welcome to Share Playlists</h1>

    <div class="button-container">
        <a href="{{ route('playlists.index') }}" class="btn">プレイリスト一覧を表示</a>
        <a href="{{ route('playlists.create') }}" class="btn">プレイリストを作成</a>
        <a href="{{ route('search') }}" class="btn">音楽検索</a>
        @if(Auth::user()->spotify_login === 1)
            <a href="{{ route('spotify.search') }}" class="btn spotify-login">プレイリストのURLを読み込む</a>
        @else
            <a href="{{ route('spotify.auth') }}" class="btn spotify-login">Spotifyでログイン</a>
        @endif
        <a class="btn logout" href="{{ route('logout') }}"

           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
            ログアウト
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </a>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFTER LOGIN</title>
</head>
<body>
<div class="container">
    <header>
        <h1>Login後のトップページの予定。</h1>
        <br>
        <a href="{{ route('search') }}">音楽検索 from iTunes</a>
        <br>
        @if(Auth::user()->spotify_login === 1)
            <a href="{{ route('spotify.create') }}">プレイリストのURLを読み込む</a>
        @else
            <a href="{{ route('spotify.auth') }}">Spotifyでログイン</a>
        @endif
        <br>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </a>
    </header>
</div>
</body>
</html>

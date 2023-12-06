<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Playlists - HOME</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

<div class="container">
    <header>
        <h1>HOME</h1>
        <br>
        <a href="{{ route('playlist.create') }}">プレイリストを作成する。</a>
        <br>
        <a href="{{ route('search') }}">音楽検索 from iTunes</a>
        <br>
        @if(Auth::user()->spotify_login === 1)
            <a href="{{ route('spotify.search') }}">プレイリストのURLを読み込む</a>
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

<button class="dark-mode-toggle" onclick="toggleDarkMode()">
    <span class="dark-mode-icon"></span>
    <span id="dark-mode-text">🌙 Dark Mode</span>
</button>

<script>
    function toggleDarkMode() {
        const body = document.querySelector('body');
        const header = document.querySelector('header');
        const links = document.querySelectorAll('a');
        const darkModeText = document.querySelector('#dark-mode-text');

        body.classList.toggle('dark-mode');
        header.classList.toggle('dark-mode');

        links.forEach(link => {
            link.classList.toggle('dark-mode');
        });

        // ダークモード時は "Light Mode"、通常モード時は "Dark Mode" に変更
        darkModeText.innerText = body.classList.contains('dark-mode') ? '🌞️ Light Mode' : '🌙 Dark Mode';
    }
</script>

</body>
</html>

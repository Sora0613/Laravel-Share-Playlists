<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Playlists - TOP</title>
    <link rel="stylesheet" href="{{ asset('css/top-styles.css') }}">
</head>
<body>
<div class="container">
    <header>
        <h1>Share Your Playlists With Others.</h1>
        <p>You can share your playlists regardless of the music site platform you use.</p>
    </header>

    <div class="cta-buttons">
        @if (Route::has('login'))
            @auth
                <a href="{{ route('/home') }}" class="neumorphism">Home</a>
            @else
                <a href="{{ route('login') }}" class="neumorphism">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="neumorphism">Register</a>
                @endif
            @endauth
        @endif
    </div>

    <button class="dark-mode-toggle" onclick="toggleDarkMode()">
        <span id="dark-mode-text">🌙 Dark Mode</span>
    </button>

    <script>
        function toggleDarkMode() {
            const body = document.querySelector('body');
            const darkModeText = document.querySelector('#dark-mode-text');
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                darkModeText.innerText = '🌙 Dark Mode';
            } else {
                body.classList.add('dark-mode');
                darkModeText.innerText = '🌞️ Light Mode';
            }
        }
    </script>
</div>
</body>
</html>

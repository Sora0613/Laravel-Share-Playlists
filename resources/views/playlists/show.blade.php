<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Playlist - Create Playlist</title>
    <link rel="stylesheet" href="{{ asset('css/search-styles.css') }}">
</head>
<body>

<div class="container">
    <a href="{{ route('index') }}" class="top-link">Back to Top</a>
    <h1>Detail of your playlist.</h1>
    @isset($message)
        <p>{{ $message }}</p>
    @endisset

    <div class="playlist-list">
        <div class="playlist-item">
            @isset($playlist)
                <h2>Playlist Name : {{ $playlist->playlist_name }}</h2>
                <p>Playlist Description : {{ $playlist->playlist_description }}</p>
            @endisset
        </div>
    </div>
</div>

</body>
</html>

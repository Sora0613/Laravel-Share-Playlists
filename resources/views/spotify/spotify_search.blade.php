<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Playlist Create</title>
    <link rel="stylesheet" href="{{ asset('css/search-styles.css') }}">
</head>
<body>

<div class="container">
    <a href="{{ route('home') }}" class="top-link">Back to Top</a>
    <h1>Import Playlist From Spotify</h1>
    @isset($message)
        <p>{{ $message }}</p>
    @endisset

    <form id="song-form" action="{{ route('spotify.playlist.search') }}" method="GET">
        @csrf
        <label for="playlist_name">Playlist Name:</label>
        <input type="text" id="playlist_name" name="playlist_name" placeholder="Playlist Title Here" required>

        <label for="playlist_description">Playlist Description:</label>
        <input type="text" id="playlist_description" name="playlist_description" placeholder="Playlist Description Here" required>

        <label for="is_private">Private Playlist:</label>
        <input type="checkbox" id="is_private" name="is_private">

        <label for="playlist-url">Playlist URL:</label>
        <input type="url" id="playlist-url" name="playlist-url" placeholder="https://open.spotify.com/playlist/*********" required>

        <button type="submit">Create Playlist</button>
    </form>
</div>

</body>
</html>

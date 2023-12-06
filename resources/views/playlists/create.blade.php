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
    <h1>Create Your Own Playlists.</h1>
    @isset($message)
        <p>{{ $message }}</p>
    @endisset

    <form id="form" action="{{ route('playlist.store') }}" method="POST">
        @csrf
        <label for="playlist-name">Playlist Name:</label>
        <input type="text" id="playlist-name" name="playlist_name" required>

        <label for="playlist-description">Playlist Description:</label>
        <input type="text" id="playlist-description" name="playlist_description" required>

        <label for="is-private">Private Playlist:</label>
        <input type="checkbox" id="is-private" name="is_private">

        <button type="submit">Create</button>
    </form>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Playlist - Create Playlist</title>
    <link rel="stylesheet" href="{{ asset('css/search-styles.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            text-align: center;
            margin: 50px auto;
            max-width: 800px;
        }

        h1 {
            font-size: 2em;
            color: #333;
        }

        .playlist-list {
            list-style: none;
            padding: 0;
        }

        .playlist-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .playlist-item a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .playlist-item a:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('home') }}" class="top-link">Back to Top</a>
    <h1>Create Your Own Playlists.</h1>
    @isset($message)
        <p>{{ $message }}</p>
    @endisset

    <form id="form" action="{{ route('playlists.store') }}" method="POST">
        @csrf
        <label for="playlist-name">Playlist Name:</label>
        <input type="text" id="playlist-name" name="playlist_name" required>

        <label for="playlist-description">Playlist Description:</label>
        <input type="text" id="playlist-description" name="playlist_description" required>

        <label for="is-private">Private Playlist:</label>
        <input type="checkbox" id="is-private" name="is_private">

        <button type="submit">Create</button>
    </form>

    <h2>Playlists</h2>
        <ul class="playlist-list">
            @if(isset($playlists))
                @foreach ($playlists as $playlist)
                    <li class="playlist-item">
                        <a href="{{ route('playlists.show', ['playlist' => $playlist['id']]) }}">{{ $playlist['playlist_name'] }}</a>
                    </li>
                @endforeach
            @else
                <li class="playlist-item">
                    <p>No playlists found.</p>
                </li>
            @endif
        </ul>
</div>

</body>
</html>

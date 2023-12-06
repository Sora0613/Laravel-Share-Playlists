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
    <a href="{{ route('index') }}" class="top-link">Back to Top</a>
    <h1>Get Songs From Playlist</h1>

    <form id="song-form" action="{{ route('spotify.playlist.search') }}" method="GET">
        @csrf
        <label for="playlist-url">Playlist URL:</label>
        <input type="url" id="playlist-url" name="playlist-url" placeholder="https://open.spotify.com/playlist/*********" required>

        <button type="submit">Create Playlist</button>
    </form>

    @isset($track_data)
        <div class="result-form">
            <table>
                <thead>
                <tr>
                    <th>Artwork</th>
                    <th>Artist</th>
                    <th>Song Title</th>
                </tr>
                </thead>
                <tbody>
                @foreach($track_data['items'] as $song)
                    <tr>
                        <td><img src="{{ $song['track']['album']['images'][0]['url'] }}" alt="song artwork" width="100" height="100"></td>
                        <td>{{ $song['track']['artists'][0]['name'] }}</td>
                        <td>{{ $song['track']['name'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endisset
</div>

</body>
</html>

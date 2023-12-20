<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Songs</title>
    <link rel="stylesheet" href="{{ asset('css/search-styles.css') }}">
</head>
<body>

<div class="container">
    <a href="{{ route('home') }}" class="top-link">Back to Top</a>
    <h1>Search Songs</h1>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <form id="song-form" action="{{ route('search.do') }}" method="GET">
        @csrf
        <label for="songs_keywords">Keyword:</label>
        <input type="text" id="songs_keywords" name="songs_keywords" required>

        <button type="submit">Search Songs</button>
    </form>

    @isset($songs)
        <div class="result-form">
            <table>
                <thead>
                <tr>
                    <th>Artwork</th>
                    <th>Artist</th>
                    <th>Song Title</th>
                    <th>Genre</th>
                    <th>Release Date</th>
                    <th>Add To ...</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($songs as $song)
                    <tr>
                        <td><img src="{{ $song['artworkUrl100'] }}" alt="song artwork"></td>
                        <td>{{ $song['artistName'] }}</td>
                        <td>{{ $song['trackName'] }}</td>
                        <td>{{ $song['primaryGenreName'] }}</td>
                        <td>{{ $song['releaseDate'] }}</td>
                        @isset($playlists)
                            <td>
                                <form action="{{ route('songs.store') }}" method="POST">
                                    @csrf
                                    <label for="Playlists">Playlists</label>
                                    <input type="hidden" name="song" value="{{ base64_encode(json_encode($song)) }}">
                                    <select name="playlist" id="playlist">
                                        @foreach($playlists as $playlist)
                                            <option value="{{ $playlist->id }}"> {{ $playlist->playlist_name }}</option>
                                        @endforeach
                                    </select>
                                    <br>
                                    <br>
                                    <button type="submit">Add</button>
                                </form>
                            </td>
                        @endisset
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endisset
</div>

</body>
</html>

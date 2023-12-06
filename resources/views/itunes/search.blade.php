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
    <a href="{{ route('index') }}" class="top-link">Back to Top</a>
    <h1>Search Songs</h1>

    <form id="song-form" action="{{ route('search.do') }}" method="GET">
        @csrf
        <label for="songs-keywords">Keyword:</label>
        <input type="text" id="songs-keywords" name="songs-keywords" required>

        <button type="submit">Search Songs</button>
    </form>

    @if (isset($songs))
        <div class="result-form">
            <table>
                <thead>
                <tr>
                    <th>Artwork</th>
                    <th>Artist</th>
                    <th>Song Title</th>
                    <th>Genre</th>
                    <th>Release Date</th>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

</body>
</html>

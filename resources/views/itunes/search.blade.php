<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>音楽検索</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<!-- Search Box Section -->
<div class="search-box-container">
    <a href="{{ route('home') }}" class="back-to-index">Homeへ戻る</a>
    <div class="search-box">
        <h1>音楽検索</h1>
        @if(session('message'))
            <p>{{ session('message') }}</p>
        @endif

        <form action="{{ route('search.do') }}" method="GET">
            @csrf
            <label for="songs_keywords">検索:</label>
            <input type="text" id="songs_keywords" name="songs_keywords" class="search-input" placeholder="アーティスト、曲名など">
            <button class="search-btn" type="submit">検索</button>
        </form>

    </div>
</div>


@isset($songs)
    <div class="search-results-container">
        <div class="search-results">
            <table>
                <thead>
                    <tr>
                        <th>Artwork</th>
                        <th>Artist</th>
                        <th>Song Title</th>
                        <th>Genre</th>
                        <th>Release Date</th>
                        <th>Add To...</th>
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
                                <div class="add-to-container">
                                    <form action="{{ route('songs.store') }}" method="POST">
                                        @csrf
                                        <label for="Playlists">Playlists</label>
                                        <input type="hidden" name="song" value="{{ base64_encode(json_encode($song)) }}">
                                        <select class="playlist-dropdown" name="playlist" id="playlist">
                                            @foreach($playlists as $playlist)
                                                <option value="{{ $playlist->id }}"> {{ $playlist->playlist_name }}</option>
                                            @endforeach
                                        </select>
                                        <br>
                                        <br>
                                        <button class="add-to-btn" type="submit">Add To</button>
                                    </form>
                                </div>
                            </td>
                        @endisset
                        <td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endisset

</body>
</html>


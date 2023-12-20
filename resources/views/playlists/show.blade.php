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
    <a href="{{ route('home') }}" class="top-link">Back to Top</a>
    <h1>Detail of your playlist.</h1>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <div class="playlist-list">
        <div class="playlist-item">
            @isset($playlist)
                <h2>Playlist Name : {{ $playlist->playlist_name }}</h2>
                <p>Playlist Description : {{ $playlist->playlist_description }}</p>


                @isset($songs)
                    <div class="result-form">
                        <table>
                            <thead>
                            <tr>
                                <th>Artwork</th>
                                <th>Artist</th>
                                <th>Song Title</th>
                                <th>Album Name</th>
                                @if($playlist->user_id === Auth::user()->id)
                                    <th>Edit</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($songs as $song)
                                <tr>
                                    <td><img src="{{ $song->artwork_url }}" alt="song artwork" width="100" height="100"></td>
                                    <td>{{ $song->artist_name }}</td>
                                    <td>{{ $song->song_name }}</td>
                                    <td>{{ $song->album_name }}</td>
                                    @if($playlist->user_id === Auth::user()->id)
                                        <td>
                                            <form action="{{ route('songs.destroy', ['song' => $song->id ]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit">Delete</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endisset
            @endisset
        </div>
    </div>
</div>

</body>
</html>

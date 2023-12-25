<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイリスト詳細</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<div class="page-container">
    <a href="{{ route('home') }}" class="back-to-index">Homeへ戻る</a>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <div class="playlist-details">
        <div class="playlist-content">
            @isset($playlist)
                <h1>{{ $playlist->playlist_name }}</h1>
                <p class="playlist-description">{{ $playlist->playlist_description }}</p>
                @if($playlist->is_private === 1)
                    <p class="playlist-description">プレイリストの状態：非公開</p>
                @else
                    <p class="playlist-description">プレイリストの状態：公開</p>
                @endif
        </div>
        @if(isset($playlist->playlist_cover))
            <img src="{{ asset('storage/playlist_cover/' . $playlist->playlist_cover) }}" alt="Playlist Image" class="playlist-image">
        @else
            <img src="{{ asset('cover.jpeg') }}" alt="Playlist Image" class="playlist-image">
        @endif
    </div>

    <a href="{{ route('playlists.edit', ["playlist" => $playlist->id]) }}" class="edit-btn">プレイリストを編集</a>
    <br>
    <br>

    <div class="search-results">
        @isset($songs)
        <table>
            <thead>
            <tr>
                <th>Artwork</th>
                <th>Artist</th>
                <th>Song Title</th>
                <th>Album name</th>
                @if($playlist->user_id === Auth::user()->id)
                    <th>Delete</th>
                @endif
            </tr>
            </thead>
            @foreach ($songs as $song)
                <tbody>
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
                                <button class="delete-btn" type="submit" onclick='return confirm("本当に削除しますか？")'>Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        @endisset
            @endisset
    </div>
</div>

</body>
</html>

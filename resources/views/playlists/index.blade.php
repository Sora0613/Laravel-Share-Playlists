<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイリスト一覧</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<div class="page-container">
    <a href="{{ route('home') }}" class="back-to-index">Homeへ戻る</a>
    <h1>プレイリスト一覧</h1>

    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <ul class="playlist-list">
        @if(isset($playlists))
            @foreach ($playlists as $playlist)
                <li>
                    @if(isset($playlist['playlist_cover']))
                        <img src="{{ asset('storage/playlist_cover/' . $playlist['playlist_cover']) }}" alt="Playlist Image" class="playlist-image">
                    @else
                        <img src="{{ asset('cover.jpeg') }}" alt="Playlist Image" class="playlist-image">
                    @endif
                        <a href="{{ route('playlists.show', ['playlist' => $playlist['id']]) }}" class="playlist-name">{{ $playlist['playlist_name'] }}</a>
                        <p class="playlist-description">{{ $playlist['playlist_description'] }}</p>

                        <form action="{{ route('playlists.destroy', ['playlist' => $playlist->id ]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn edit-btn">Delete</button>
                        </form>
                </li>
            @endforeach
        @else
            <li>
                <p>No playlists found.</p>
            </li>
        @endif
    </ul>

</div>
</body>
</html>

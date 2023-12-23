<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイリストインポート</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<div class="page-container">
    <a href="{{ route('home') }}" class="back-to-index">Homeへ戻る</a>
    <h1>プレイリストインポート</h1>
    @isset($message)
        <p>{{ $message }}</p>
    @endisset

    <form action="{{ route('spotify.playlist.search') }}" method="GET">
        @csrf
        <div class="form-group">
            <label for="playlist-url">プレイリストURL:</label>
            <input id="playlist-url" name="playlist-url" class="rounded-input" required>
        </div>

        <div class="form-group">
            <label for="playlist_name">プレイリスト名:</label>
            <input type="text" id="playlist_name" name="playlist_name" class="large-input" required>
        </div>

        <div class="form-group">
            <label for="playlist_description">プレイリスト説明:</label>
            <input id="playlist_description" name="playlist_description" class="rounded-input" required>
        </div>

        <div class="form-group checkbox-group">
            <label for="is_private">非公開にする:</label>
            <input type="checkbox" id="is_private" name="is_private">
        </div>

        <button class="btn" type="submit">インポート</button>
    </form>
</div>

</body>
</html>


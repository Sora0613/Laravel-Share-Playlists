<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイリスト作成</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<div class="page-container">
    <a href="{{ route('home') }}" class="back-to-index">Homeへ戻る</a>
    <h1>プレイリスト作成</h1>
    @isset($message)
        <p>{{ $message }}</p>
    @endisset

    <form action="{{ route('playlists.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="playlist_name">プレイリスト名:</label>
            <input type="text" id="playlist_name" name="playlist_name" class="large-input" required>
        </div>

        <div class="form-group">
            <label for="playlist_description">プレイリスト説明:</label>
            <input id="playlist_description" name="playlist_description" class="rounded-input">
        </div>

        <div class="form-group checkbox-group">
            <label for="is_private">非公開にする:</label>
            <input type="checkbox" id="is_private" name="is_private">
        </div>

        <button class="btn" type="submit">作成する</button>
    </form>
</div>

</body>
</html>


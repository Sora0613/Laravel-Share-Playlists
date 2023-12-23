<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイリスト詳細</title>
    <link rel="stylesheet" href="{{ asset('css/new_styles.css') }}">
</head>
<body>

<!-- Edit Page -->
<div class="page-container">
    <a href="{{ route('home') }}" class="back-to-index">Homeへ戻る</a>
    @isset($playlist)
        <form action="{{ route('playlists.update', ['playlist' => $playlist->id ]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <h1>プレイリストを編集</h1>
            <div class="form-group">
                <label for="playlist_name">プレイリスト名:</label>
                <input type="text" id="playlist_name" name="playlist_name" class="large-input" placeholder="プレイリスト名">
            </div>

            <div class="form-group">
                <label for="playlist_description">プレイリストの説明:</label>
                <input type="text" id="playlist_description" name="playlist_description" class="large-input" placeholder="プレイリストの説明">
            </div>

            <div class="form-group checkbox-group">
                <label for="is_private">非公開にする:</label>
                <input type="checkbox" id="is_private" name="is_private" value="1" {{ $playlist->is_private ? 'checked' : '' }}>
            </div>

            <div class="form-group">
                <label for="playlist_cover">プレイリスト画像:</label>
                <input type="file" id="playlist_cover" name="playlist_cover">
            </div>

            <button type="submit" class="btn">保存</button>
        </form>
    @endisset
</div>
</body>
</html>

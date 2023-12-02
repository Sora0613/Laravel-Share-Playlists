<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify CallBack</title>
</head>
<body>
<div class="container">
    @isset($message)
        <p>{{ $message }}</p>
    @endisset
    @isset($access_token)
        <p>Access Token: {{ $access_token }}</p>
    @endisset
    @isset($refresh_token)
        <p>Refresh Token: {{ $refresh_token }}</p>
    @endisset
    @isset($expires_in)
        <p>Expires In: {{ $expires_in }}</p>
    @endisset
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Login</h2>
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="neumorphism">Login</button>
            </div>
        </form>
        <p class="link">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
    </div>
</div>

<button class="dark-mode-toggle" onclick="toggleDarkMode()">
    <span id="dark-mode-text">🌙 Dark Mode</span>
</button>

<script src="{{ asset('js/form.js') }}"></script>

</body>
</html>

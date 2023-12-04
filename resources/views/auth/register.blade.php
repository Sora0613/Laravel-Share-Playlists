<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}">
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Register</h2>
        <form action="{{ route('register') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="register-username">Username:</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="register-email">Email:</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <button type="submit" class="neumorphism">Register</button>
            </div>
        </form>
        <p class="link">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
    </div>
</div>

<button class="dark-mode-toggle" onclick="toggleDarkMode()">
    <span id="dark-mode-text">🌙 Dark Mode</span>
</button>

<script src="{{ asset('js/form.js') }}"></script>

</body>
</html>

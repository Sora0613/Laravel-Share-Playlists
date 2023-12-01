<!DOCTYPE html>
<html lang="en">
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
        <form action="#" method="post">
            <div class="form-group">
                <label for="login-username">Username:</label>
                <input type="text" id="login-username" name="login-username" required>
            </div>
            <div class="form-group">
                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="login-password" required>
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

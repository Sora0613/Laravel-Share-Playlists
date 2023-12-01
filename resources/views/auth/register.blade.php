<!DOCTYPE html>
<html lang="en">
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
        <form action="#" method="post">
            <div class="form-group">
                <label for="register-username">Username:</label>
                <input type="text" id="register-username" name="register-username" required>
            </div>
            <div class="form-group">
                <label for="register-email">Email:</label>
                <input type="email" id="register-email" name="register-email" required>
            </div>
            <div class="form-group">
                <label for="register-password">Password:</label>
                <input type="password" id="register-password" name="register-password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
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

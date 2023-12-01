function toggleDarkMode() {
    const body = document.body;
    const formContainer = document.querySelector('.form-container');
    const darkModeText = document.getElementById('dark-mode-text');

    body.classList.toggle('dark-mode');
    formContainer.classList.toggle('dark-mode');

    // ダークモード時は "Light Mode"、通常モード時は "Dark Mode" に変更
    darkModeText.innerText = body.classList.contains('dark-mode') ? '🌞 Light Mode' : '🌙 Dark Mode';
}

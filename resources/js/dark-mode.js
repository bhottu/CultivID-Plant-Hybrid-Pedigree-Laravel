document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggles = document.querySelectorAll('.dark-mode-toggle');
    const body = document.body;
    const isDarkMode = localStorage.getItem('darkMode') === 'dark';

    // Initialize dark mode state on page load
    if (isDarkMode) {
        body.classList.add('dark');
    } else {
        body.classList.remove('dark');
    }

    // Add event listeners to all toggle buttons
    darkModeToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const isDark = body.classList.toggle('dark');
            const newMode = isDark ? 'dark' : 'light';

            // Update the localStorage value
            localStorage.setItem('darkMode', newMode);

            // Update the toggle button icon for all toggles
            darkModeToggles.forEach(btn => {
                btn.innerHTML = isDark ? '<i class="fas fa-toggle-off"></i>' : '<i class="fas fa-toggle-on"></i>';
            });
        });
    });
});
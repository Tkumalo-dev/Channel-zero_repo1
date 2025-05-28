document.addEventListener('DOMContentLoaded', () => {
    const lightModeBtn = document.getElementById('light-mode-btn');
    const darkModeBtn = document.getElementById('dark-mode-btn');
    const body = document.body;

    // Function to set the theme
    const setTheme = (theme) => {
        body.classList.remove('light-mode', 'dark-mode');
        body.classList.add(`${theme}-mode`);

        // Update button states
        if (theme === 'light') {
            lightModeBtn.classList.add('active');
            darkModeBtn.classList.remove('active');
        } else {
            darkModeBtn.classList.add('active');
            lightModeBtn.classList.remove('active');
        }

        // Save to local storage
        localStorage.setItem('dashboardTheme', theme);
    };

    // Load saved or default theme
    const savedTheme = localStorage.getItem('dashboardTheme');
    if (savedTheme) {
        setTheme(savedTheme);
    } else {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        setTheme(prefersDark ? 'dark' : 'light');
    }

    // Event Listeners
    lightModeBtn.addEventListener('click', () => setTheme('light'));
    darkModeBtn.addEventListener('click', () => setTheme('dark'));

    // Navigation highlighting
    const navLinks = document.querySelectorAll('.sidebar-nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            navLinks.forEach(l => l.parentElement.classList.remove('active'));
            this.parentElement.classList.add('active');
            e.preventDefault();
            console.log(`Maps to: ${this.textContent.trim()}`);
        });
    });
});
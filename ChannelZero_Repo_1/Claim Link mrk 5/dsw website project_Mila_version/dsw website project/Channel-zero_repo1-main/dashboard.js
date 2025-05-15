document.addEventListener('DOMContentLoaded', () => {
    const lightModeBtn = document.getElementById('light-mode-btn');
    const darkModeBtn = document.getElementById('dark-mode-btn');
    const body = document.body;

    // Function to set the theme
    const setTheme = (theme) => {
        body.classList.remove('light-mode', 'dark-mode'); // Remove existing theme classes
        body.classList.add(theme + '-mode'); // Add the new theme class

        // Update button active states
        if (theme === 'light') {
            lightModeBtn.classList.add('active');
            darkModeBtn.classList.remove('active');
        } else {
            darkModeBtn.classList.add('active');
            lightModeBtn.classList.remove('active');
        }

        // Optional: Save theme preference to local storage
        localStorage.setItem('dashboardTheme', theme);
    };

    // Event Listeners for theme buttons
    lightModeBtn.addEventListener('click', () => setTheme('light'));
    darkModeBtn.addEventListener('click', () => setTheme('dark'));

    // Optional: Load saved theme preference on page load
    const savedTheme = localStorage.getItem('dashboardTheme');
    if (savedTheme) {
        setTheme(savedTheme); // Apply saved theme
    } else {
        // Optional: Check system preference if no theme is saved
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        setTheme(prefersDark ? 'dark' : 'light');
        // Or just default to dark as per the initial class on body
        // setTheme('dark');
    }

    // --- Add other dashboard interactivity here ---
    // Example: Handle navigation link clicks (if building a Single Page App)
    const navLinks = document.querySelectorAll('.sidebar-nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            navLinks.forEach(l => l.parentElement.classList.remove('active'));
            // Add active class to the clicked link's parent li
            this.parentElement.classList.add('active');

            // If not building an SPA, prevent default link behavior
            // or load the corresponding page if these were real links.
             e.preventDefault();
             console.log(`Maps to: ${this.textContent.trim()}`);
        });
    });

});
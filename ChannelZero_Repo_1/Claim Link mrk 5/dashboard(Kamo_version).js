document.addEventListener('DOMContentLoaded', () => {
    const lightModeBtn = document.getElementById('light-mode-btn');
    const darkModeBtn = document.getElementById('dark-mode-btn');
    const body = document.body;
    const settingsBtn = document.getElementById('settings-toggle');
    const mapNavLink = document.getElementById('map-nav-link');
    const dashboardContent = document.getElementById('dashboard-content');
    const mapContent = document.getElementById('map-content');
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');

    // Function to set the theme
    const setTheme = (theme) => {
        body.classList.remove('light-mode', 'dark-mode');
        body.classList.add(`${theme}-mode`);

        if (theme === 'light') {
            lightModeBtn.classList.add('active');
            darkModeBtn.classList.remove('active');
        } else {
            darkModeBtn.classList.add('active');
            lightModeBtn.classList.remove('active');
        }

        localStorage.setItem('dashboardTheme', theme);
    };

    // Toggle theme based on current one
    const toggleTheme = () => {
        const isCurrentlyDark = body.classList.contains('dark-mode');
        setTheme(isCurrentlyDark ? 'light' : 'dark');
    };

    // Event Listeners for theme buttons
    lightModeBtn.addEventListener('click', () => setTheme('light'));
    darkModeBtn.addEventListener('click', () => setTheme('dark'));

    // Add event listener to settings button (to toggle theme)
    if (settingsBtn) {
        settingsBtn.addEventListener('click', toggleTheme);
    }

    // Load saved theme preference
    const savedTheme = localStorage.getItem('dashboardTheme');
    if (savedTheme) {
        setTheme(savedTheme);
    } else {
        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        setTheme(prefersDark ? 'dark' : 'light');
    }

    // Sidebar navigation link handling
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
            this.parentElement.classList.add('active');
        });
    });

    // Map navigation
    mapNavLink.addEventListener('click', e => {
        e.preventDefault();
        dashboardContent.style.display = 'none';
        mapContent.style.display = 'block';
        sidebarLinks.forEach(link => link.parentElement.classList.remove('active'));
        mapNavLink.parentElement.classList.add('active');
    });

    // Show dashboard for other sidebar links
    sidebarLinks.forEach(link => {
        if (link !== mapNavLink) {
            link.addEventListener('click', e => {
                e.preventDefault();
                dashboardContent.style.display = 'grid';
                mapContent.style.display = 'none';
                sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
                link.parentElement.classList.add('active');
            });
        }
    });
});

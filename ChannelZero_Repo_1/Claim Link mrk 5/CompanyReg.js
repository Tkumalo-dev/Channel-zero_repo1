document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll('.error').forEach(el => el.remove());

        // Validate email
        const email = document.getElementById('company_email');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            showError(email, 'Please enter a valid email address.');
            isValid = false;
        }

        // Validate password strength
        const password = document.getElementById('password');
        if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(password.value)) {
            showError(password, 'Must include uppercase, lowercase, number, and special character.');
            isValid = false;
        }

        // Confirm password match
        const confirmPassword = document.getElementById('confirm_password');
        if (password.value !== confirmPassword.value) {
            showError(confirmPassword, 'Passwords do not match.');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    function showError(input, message) {
        const error = document.createElement('div');
        error.className = 'error';
        error.style.color = 'red';
        error.style.marginTop = '-15px';
        error.style.marginBottom = '15px';
        error.textContent = message;
        input.parentNode.insertBefore(error, input.nextSibling);
    }
});
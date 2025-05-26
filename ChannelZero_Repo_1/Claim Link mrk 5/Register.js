document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.querySelector('.registration-form');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Password validation
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long');
                return;
            }
            
            // Enhanced password strength check
            const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!strongRegex.test(password)) {
                alert('Password must contain uppercase, lowercase, number and special character');
                return;
            }
            
            // Submit form if all validations pass
            registerForm.submit();
        });
    }

    // Password visibility toggle (unchanged)
    const togglePassword = (input) => {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
    };
  
    [document.getElementById('password'), document.getElementById('confirm-password')].forEach(input => {
        if (input) {
            const eyeIcon = document.createElement('span');
            eyeIcon.innerHTML = '👁️';
            eyeIcon.style.cursor = 'pointer';
            eyeIcon.style.marginLeft = '-30px';
            eyeIcon.addEventListener('click', () => togglePassword(input));
            input.insertAdjacentElement('afterend', eyeIcon);
        }
    });
});
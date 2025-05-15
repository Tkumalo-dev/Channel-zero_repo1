document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    const registerForm = document.querySelector('.registration-form');
    if (registerForm) {
      registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get password values
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        
        // Check if passwords match
        if (password !== confirmPassword) {
          alert('Passwords do not match!');
          return;
        }
        
        // Basic password strength check
        if (password.length < 8) {
          alert('Password must be at least 8 characters long');
          return;
        }
        
        // Collect all form data (in a real app, you'd send this to a server)
        const formData = {
          firstName: document.getElementById('first-name').value,
          lastName: document.getElementById('last-name').value,
          email: document.getElementById('email').value,
          username: document.getElementById('username').value
          // Add other fields as needed
        };
        

      });
    }
  
    // Add password visibility toggle
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const togglePassword = (input) => {
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
    };
  
    // Add eye icons next to password fields (you'll need to add these elements to your HTML)
    const addPasswordToggles = () => {
      [passwordInput, confirmPasswordInput].forEach(input => {
        if (input) {
          const eyeIcon = document.createElement('span');
          eyeIcon.innerHTML = '👁️';
          eyeIcon.style.cursor = 'pointer';
          eyeIcon.style.marginLeft = '-30px';
          eyeIcon.addEventListener('click', () => togglePassword(input));
          input.insertAdjacentElement('afterend', eyeIcon);
        }
      });
    };
  
    addPasswordToggles();
  });
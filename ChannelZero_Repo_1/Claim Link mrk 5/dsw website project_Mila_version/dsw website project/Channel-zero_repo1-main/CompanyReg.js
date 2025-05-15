document.querySelector('form').addEventListener('submit', function(event) {
  // Clear previous errors
  const errors = document.querySelectorAll('.error');
  errors.forEach(e => e.remove());

  // Get form values
  const email = document.getElementById('company_email').value.trim();
  const password = document.getElementById('password').value;
  const confirmPassword = document.getElementById('confirm_password').value;

  // Email validation
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    showError('company_email', 'Please enter a valid email address.');
    event.preventDefault();
  }

  // Password strength validation
  const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
  if (!passwordPattern.test(password)) {
    showError('password', 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');
    event.preventDefault();
  }

  // Confirm password match
  if (password !== confirmPassword) {
    showError('confirm_password', 'Passwords do not match.');
    event.preventDefault();
  }

  function showError(id, message) {
    const input = document.getElementById(id);
    const error = document.createElement('div');
    error.className = 'error';
    error.style.color = 'red';
    error.innerText = message;
    input.parentNode.insertBefore(error, input.nextSibling);
  }
});


document.addEventListener('DOMContentLoaded', function() {
  const loginForm = document.querySelector('.login-form');
  if (loginForm) {
      loginForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          const username = document.getElementById('username').value;
          const password = document.getElementById('password').value;
          
          if (!username || !password) {
              alert('Please fill in all fields');
              return;
          }
          
        
          window.location.href = 'home-page.html';
      });
  }

  
});

document.addEventListener('DOMContentLoaded', () => {
  const fundsForm = document.getElementById('funds-form');
  const fundResult = document.getElementById('fund-result');
  const loader = document.getElementById('loader');
  const container = document.querySelector('.container');
  const resetBtn = document.getElementById('reset-btn');

  // Show loader during form submission
  if (fundsForm) {
    fundsForm.addEventListener('submit', function() {
      loader.style.display = 'block';
      fundResult.innerHTML = '';
    });
  }

  // Reset button functionality
  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      container.classList.remove('split');
      container.classList.add('initial');
      if (fundsForm) fundsForm.reset();
      fundResult.innerHTML = '';
      resetBtn.style.display = 'none';
      window.history.pushState({}, document.title, window.location.pathname);
    });
  }

  // If coming back with search results, keep the split view
  if (window.location.search.includes('search=1')) {
    container.classList.remove('initial');
    container.classList.add('split');
    if (resetBtn) resetBtn.style.display = 'block';
  }
});
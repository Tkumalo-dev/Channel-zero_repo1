document.addEventListener("DOMContentLoaded", function () {
  // Handle login button click
  const loginBtn = document.querySelector(".login-btn");
  if (loginBtn) {
    loginBtn.addEventListener("click", function () {
      window.location.href = "login.php";
    });
  }
  const startSearchBtn = document.querySelector(
    '.primary-btn[data-action="start-search"]'
  );
  if (startSearchBtn) {
    startSearchBtn.addEventListener("click", function (e) {
      e.preventDefault();
      window.location.href = "log-claim.php";
    });
    4;
  }

  // Handle register button clicks
  const registerBtns = document.querySelectorAll(".primary-btn");
  registerBtns.forEach((btn) => {
    if (btn.textContent.trim() === "Register") {
      btn.addEventListener("click", function () {
        window.location.href = "Register.php";
      });
    }
  });

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const targetId = this.getAttribute("href");
      if (targetId !== "#") {
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: "smooth",
          });
        }
      }
    });
  });
});

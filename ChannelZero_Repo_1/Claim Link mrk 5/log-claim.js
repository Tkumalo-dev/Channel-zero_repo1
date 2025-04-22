document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("apply-btn");
    const target = document.getElementById("log-claim");

    btn.addEventListener("click", function (e) {
      e.preventDefault();
      target.scrollIntoView({ behavior: "smooth" });
    });
  });
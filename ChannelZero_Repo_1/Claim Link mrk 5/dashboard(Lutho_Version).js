document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Content Loaded");

  // Add New Modal functionality
  const addNewBtn = document.querySelector(".btn-add-new");
  const addNewModal = document.getElementById("addNewModal");
  const cancelBtn = document.getElementById("cancelAddNew");
  const submitBtn = document.getElementById("submitAddNew");
  const newClaimText = document.getElementById("newClaimText");
  const mapNavLink = document.getElementById("map-nav-link");
  const dashboardContent = document.getElementById("dashboard-content");
  const mapContent = document.getElementById("map-content");
  const sidebarLinks = document.querySelectorAll(".sidebar-nav a");

  console.log("Map Nav Link:", mapNavLink);
  console.log("Dashboard Content:", dashboardContent);
  console.log("Map Content:", mapContent);

  // Open modal on Add New click
  addNewBtn.addEventListener("click", () => {
    addNewModal.style.display = "flex";
  });

  // Close modal on cancel
  cancelBtn.addEventListener("click", () => {
    addNewModal.style.display = "none";
    newClaimText.value = "";
  });

  // Submit new claim (example action)
  submitBtn.addEventListener("click", () => {
    if (newClaimText.value.trim() === "") {
      alert("Please enter your claim details.");
      return;
    }
    alert("New claim submitted: " + newClaimText.value);
    newClaimText.value = "";
    addNewModal.style.display = "none";
  });

  // Close modal if clicking outside the content box
  addNewModal.addEventListener("click", (e) => {
    if (e.target === addNewModal) {
      addNewModal.style.display = "none";
      newClaimText.value = "";
    }
  });

  // Sidebar navigation link handling
  sidebarLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      // Only prevent default for internal links (those with # or no href)
      if (!this.getAttribute("href") || this.getAttribute("href") === "#") {
        e.preventDefault();
        console.log("Internal link clicked:", this.textContent);
        sidebarLinks.forEach((l) => l.parentElement.classList.remove("active"));
        this.parentElement.classList.add("active");
      } else {
        // For external links (like search.php), let the default navigation happen
        console.log("External link clicked:", this.getAttribute("href"));
      }
    });
  });

  // Map navigation
  mapNavLink.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("Map link clicked");
    dashboardContent.style.display = "none";
    mapContent.style.display = "block";
    sidebarLinks.forEach((link) =>
      link.parentElement.classList.remove("active")
    );
    mapNavLink.parentElement.classList.add("active");
  });

  // Show dashboard for other sidebar links
  sidebarLinks.forEach((link) => {
    if (
      link !== mapNavLink &&
      (!link.getAttribute("href") || link.getAttribute("href") === "#")
    ) {
      link.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("Dashboard link clicked");
        dashboardContent.style.display = "grid";
        mapContent.style.display = "none";
        sidebarLinks.forEach((l) => l.parentElement.classList.remove("active"));
        link.parentElement.classList.add("active");
      });
    }
  });
});

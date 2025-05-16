document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("uploadForm");
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("fileInput");
  const saveDraftBtn = document.getElementById("saveDraft");
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("emailError");
  const trackingInfo = document.getElementById("trackingInfo");
  const trackingId = document.getElementById("trackingId");
  const documentStatus = document.getElementById("documentStatus");

  // Generate random tracking ID
  function generateTrackingId() {
    return (
      "UFD-" +
      new Date().getFullYear() +
      "-" +
      Math.random().toString(36).substr(2, 5).toUpperCase()
    );
  }

  // Save form data to localStorage
  function saveDraft() {
    const formData = {
      companyName: document.getElementById("companyName").value,
      contactPerson: document.getElementById("contactPerson").value,
      email: emailInput.value,
    };

    localStorage.setItem("uploadFormDraft", JSON.stringify(formData));
    alert("Draft saved successfully!");
  }

  // Load draft data if exists
  function loadDraft() {
    const savedData = localStorage.getItem("uploadFormDraft");
    if (savedData) {
      const formData = JSON.parse(savedData);
      document.getElementById("companyName").value = formData.companyName || "";
      document.getElementById("contactPerson").value =
        formData.contactPerson || "";
      emailInput.value = formData.email || "";
    }
  }

  // Check if email is valid
  function isValidEmail(email) {
    return email.includes("@") && email.includes(".");
  }

  // Handle form submission
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    // Check email
    if (!isValidEmail(emailInput.value)) {
      emailError.style.display = "block";
      return;
    }

    // Generate tracking ID
    const newTrackingId = generateTrackingId();

    // Show tracking info
    trackingId.textContent = newTrackingId;
    documentStatus.textContent = "UPLOADED";
    trackingInfo.classList.remove("hidden");

    // Clear draft
    localStorage.removeItem("uploadFormDraft");
    alert("Document uploaded successfully!");
  });

  // Handle drag and drop
  dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("drag-over");
  });

  dropZone.addEventListener("dragleave", () => {
    dropZone.classList.remove("drag-over");
  });

  dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("drag-over");
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      fileInput.files = files;
      alert("File selected: " + files[0].name);
    }
  });

  // Handle click on upload area
  dropZone.addEventListener("click", () => {
    fileInput.click();
  });

  fileInput.addEventListener("change", () => {
    if (fileInput.files.length > 0) {
      alert("File selected: " + fileInput.files[0].name);
    }
  });

  // Save draft button click
  saveDraftBtn.addEventListener("click", saveDraft);

  // Load draft on page load
  loadDraft();

  // Add styles for notification
  const style = document.createElement("style");
  style.textContent = `
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--success-color);
            color: white;
            padding: 1rem 2rem;
            border-radius: 4px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1; 
            }
        }
    `;
  document.head.appendChild(style);
});

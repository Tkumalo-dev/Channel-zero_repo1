document.addEventListener("DOMContentLoaded", () => {
  // Get all upload areas and their corresponding inputs
  const uploadAreas = {
    id: {
      area: document.getElementById("idUpload"),
      input: document.getElementById("idInput"),
      file: null,
    },
    policy: {
      area: document.getElementById("policyUpload"),
      input: document.getElementById("policyInput"),
      file: null,
    },
    deathCert: {
      area: document.getElementById("deathCertUpload"),
      input: document.getElementById("deathCertInput"),
      file: null,
    },
  };

  // Setup upload functionality for each area
  Object.values(uploadAreas).forEach(({ area, input }) => {
    // Click to upload
    area.addEventListener("click", () => input.click());
    input.addEventListener("change", (e) => handleFileSelect(e, area, input));

    // Drag and drop
    ["dragover", "dragleave", "drop"].forEach((eventType) => {
      area.addEventListener(eventType, (e) => {
        e.preventDefault();
        if (eventType === "dragover") area.classList.add("drag-over");
        if (eventType === "dragleave") area.classList.remove("drag-over");
        if (eventType === "drop") {
          area.classList.remove("drag-over");
          input.files = e.dataTransfer.files;
          handleFileSelect(e, area, input);
        }
      });
    });
  });

  // Handle file selection
  function handleFileSelect(event, area, input) {
    const file = input.files[0];
    if (file) {
      // Validate file type
      const validTypes = [".pdf", ".jpg", ".jpeg", ".png"];
      const fileExtension = "." + file.name.split(".").pop().toLowerCase();

      if (!validTypes.includes(fileExtension)) {
        showError(
          area,
          "Please upload a valid file type (PDF, JPG, JPEG, or PNG)"
        );
        input.value = "";
        return;
      }

      // Validate file size (max 5MB)
      if (file.size > 5 * 1024 * 1024) {
        showError(area, "File size must be less than 5MB");
        input.value = "";
        return;
      }

      // Update UI to show selected file
      const fileName =
        file.name.length > 20 ? file.name.substring(0, 17) + "..." : file.name;
      area.innerHTML = `
                <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon" />
                <span>${fileName}</span>
                <button type="button" class="remove-file">×</button>
            `;

      // Add remove file functionality
      const removeButton = area.querySelector(".remove-file");
      removeButton.addEventListener("click", (e) => {
        e.stopPropagation();
        input.value = "";
        resetUploadArea(area);
      });

      // Store file reference
      const uploadType = Object.keys(uploadAreas).find(
        (key) => uploadAreas[key].area === area
      );
      uploadAreas[uploadType].file = file;
    }
  }

  // Reset upload area to initial state
  function resetUploadArea(area) {
    area.innerHTML = `
            <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon" />
            <span>Upload ${area.id.replace("Upload", "")}</span>
        `;
  }

  // Show error message
  function showError(element, message) {
    const errorDiv = document.createElement("div");
    errorDiv.className = "error-message";
    errorDiv.textContent = message;
    element.appendChild(errorDiv);
    setTimeout(() => errorDiv.remove(), 3000);
  }

  // Form validation
  const form = document.getElementById("uploadForm");
  const emailInput = document.getElementById("email");
  const emailError = document.getElementById("emailError");

  // Email validation
  emailInput.addEventListener("input", () => {
    const email = emailInput.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      emailError.style.display = "block";
    } else {
      emailError.style.display = "none";
    }
  });

  // Form submission
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Validate all required files are uploaded
    const missingFiles = Object.entries(uploadAreas)
      .filter(([_, { file }]) => !file)
      .map(([type]) => type);

    if (missingFiles.length > 0) {
      alert(`Please upload all required documents: ${missingFiles.join(", ")}`);
      return;
    }

    // Validate email
    if (emailError.style.display === "block") {
      alert("Please enter a valid email address");
      return;
    }

    // Create FormData object
    const formData = new FormData();
    Object.entries(uploadAreas).forEach(([type, { file }]) => {
      formData.append(type, file);
    });

    // Add other form fields
    formData.append("fullName", document.getElementById("fullName").value);
    formData.append(
      "relationship",
      document.getElementById("relationship").value
    );
    formData.append("email", emailInput.value);
    formData.append("phone", document.getElementById("phone").value);

    try {
      // Show loading state
      const submitButton = form.querySelector('button[type="submit"]');
      const originalText = submitButton.textContent;
      submitButton.textContent = "Uploading...";
      submitButton.disabled = true;

      // Simulate API call (replace with actual API endpoint)
      const response = await fetch("/api/upload", {
        method: "POST",
        body: formData,
      });

      if (!response.ok) {
        throw new Error("Upload failed");
      }

      const result = await response.json();

      // Show tracking info
      document.getElementById("trackingInfo").classList.remove("hidden");
      document.getElementById("trackingId").textContent = result.trackingId;
      document.getElementById("claimStatus").textContent = "Processing";

      // Reset form
      form.reset();
      Object.values(uploadAreas).forEach(({ area }) => resetUploadArea(area));
    } catch (error) {
      alert("An error occurred while uploading. Please try again.");
    } finally {
      // Reset button state
      submitButton.textContent = originalText;
      submitButton.disabled = false;
    }
  });

  // Save draft functionality
  document.getElementById("saveDraft").addEventListener("click", () => {
    const formData = {
      fullName: document.getElementById("fullName").value,
      relationship: document.getElementById("relationship").value,
      email: document.getElementById("email").value,
      phone: document.getElementById("phone").value,
      files: Object.entries(uploadAreas).map(([type, { file }]) => ({
        type,
        name: file ? file.name : null,
      })),
    };

    localStorage.setItem("claimDraft", JSON.stringify(formData));
    alert("Draft saved successfully!");
  });

  // Load draft if exists
  const savedDraft = localStorage.getItem("claimDraft");
  if (savedDraft) {
    const draft = JSON.parse(savedDraft);
    document.getElementById("fullName").value = draft.fullName || "";
    document.getElementById("relationship").value = draft.relationship || "";
    document.getElementById("email").value = draft.email || "";
    document.getElementById("phone").value = draft.phone || "";
  }
});

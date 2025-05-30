document.addEventListener("DOMContentLoaded", () => {
  // DOM Elements
  const darkModeToggle = document.getElementById("dark-mode-toggle");
  const emailNotifications = document.getElementById("email-notifications");
  const smsNotifications = document.getElementById("sms-notifications");
  const notificationSound = document.getElementById("notification-sound");
  const textSize = document.getElementById("text-size");
  const highContrast = document.getElementById("high-contrast");
  const language = document.getElementById("language");
  const deleteAccountBtn = document.getElementById("delete-account-btn");
  const deleteConfirmationModal = document.getElementById(
    "delete-confirmation-modal"
  );
  const cancelDelete = document.getElementById("cancel-delete");
  const confirmDelete = document.getElementById("confirm-delete");
  const successMessage = document.getElementById("success-message");
  const errorMessage = document.getElementById("error-message");

  // Terms & Conditions Modal
  const termsModal = document.getElementById("terms-modal");
  const termsBtn = document.getElementById("terms-btn");
  const termsCloseBtn = termsModal.querySelector(".close-modal");

  // Account Creation Form
  const createAccountForm = document.getElementById("create-account-form");

  // Load saved settings from localStorage
  const loadSettings = () => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {
      darkMode: false,
      emailNotifications: true,
      smsNotifications: false,
      notificationSound: true,
      textSize: "medium",
      highContrast: false,
      language: "en",
    };

    darkModeToggle.checked = settings.darkMode;
    emailNotifications.checked = settings.emailNotifications;
    smsNotifications.checked = settings.smsNotifications;
    notificationSound.checked = settings.notificationSound;
    textSize.value = settings.textSize;
    highContrast.checked = settings.highContrast;
    language.value = settings.language;

    applySettings(settings);
  };

  // Apply settings to the UI
  const applySettings = (settings) => {
    // Apply dark mode
    document.body.classList.toggle("dark-mode", settings.darkMode);

    // Apply text size
    document.body.style.fontSize = {
      small: "14px",
      medium: "16px",
      large: "18px",
    }[settings.textSize];

    // Apply high contrast
    document.body.classList.toggle("high-contrast", settings.highContrast);

    // Apply language (in a real app, this would load translations)
    document.documentElement.lang = settings.language;
  };

  // Save settings to localStorage
  const saveSettings = (settings) => {
    localStorage.setItem("userSettings", JSON.stringify(settings));
    showMessage("Settings saved successfully!", "success");
  };

  // Show message
  const showMessage = (message, type) => {
    const messageElement = type === "success" ? successMessage : errorMessage;
    const otherElement = type === "success" ? errorMessage : successMessage;

    messageElement.textContent = message;
    messageElement.style.display = "block";
    otherElement.style.display = "none";

    setTimeout(() => {
      messageElement.style.display = "none";
    }, 3000);
  };

  // Event Listeners
  darkModeToggle.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.darkMode = e.target.checked;
    saveSettings(settings);
    applySettings(settings);
  });

  emailNotifications.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.emailNotifications = e.target.checked;
    saveSettings(settings);
  });

  smsNotifications.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.smsNotifications = e.target.checked;
    saveSettings(settings);
  });

  notificationSound.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.notificationSound = e.target.checked;
    saveSettings(settings);
  });

  textSize.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.textSize = e.target.value;
    saveSettings(settings);
    applySettings(settings);
  });

  highContrast.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.highContrast = e.target.checked;
    saveSettings(settings);
    applySettings(settings);
  });

  language.addEventListener("change", (e) => {
    const settings = JSON.parse(localStorage.getItem("userSettings")) || {};
    settings.language = e.target.value;
    saveSettings(settings);
    applySettings(settings);
  });

  // Delete Account
  deleteAccountBtn.addEventListener("click", () => {
    deleteConfirmationModal.style.display = "flex";
  });

  cancelDelete.addEventListener("click", () => {
    deleteConfirmationModal.style.display = "none";
  });

  confirmDelete.addEventListener("click", () => {
    // In a real application, this would make an API call to delete the account
    showMessage(
      "Account deleted successfully. Redirecting to login page...",
      "success"
    );
    setTimeout(() => {
      window.location.href = "login.html";
    }, 2000);
  });

  // Close modal when clicking outside
  deleteConfirmationModal.addEventListener("click", (e) => {
    if (e.target === deleteConfirmationModal) {
      deleteConfirmationModal.style.display = "none";
    }
  });

  // Terms & Conditions Modal
  termsBtn.addEventListener("click", () => {
    termsModal.style.display = "flex";
  });

  termsCloseBtn.addEventListener("click", () => {
    termsModal.style.display = "none";
  });

  window.addEventListener("click", (e) => {
    if (e.target === termsModal) {
      termsModal.style.display = "none";
    }
  });

  // Account Creation Form
  createAccountForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Clear previous errors
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach((msg) => msg.remove());
    const errorInputs = document.querySelectorAll(".error");
    errorInputs.forEach((input) => input.classList.remove("error"));

    const formData = new FormData(createAccountForm);

    try {
      const response = await fetch("create_account.php", {
        method: "POST",
        body: formData,
      });

      const data = await response.json();

      if (response.ok) {
        showMessage(data.message, "success");
        createAccountForm.reset();
      } else {
        if (data.errors) {
          // Display validation errors
          Object.entries(data.errors).forEach(([field, message]) => {
            const input = document.getElementById(`new-${field}`);
            input.classList.add("error");

            const errorDiv = document.createElement("div");
            errorDiv.className = "error-message";
            errorDiv.textContent = message;
            input.parentNode.appendChild(errorDiv);
          });
        } else {
          showMessage(data.error, "error");
        }
      }
    } catch (error) {
      showMessage("An error occurred. Please try again.", "error");
    }
  });

  // Initialize settings
  loadSettings();
});

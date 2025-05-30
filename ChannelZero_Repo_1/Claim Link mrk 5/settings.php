<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Settings - Fund Claimer</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link rel="stylesheet" href="side_nav.css" />
    <link rel="stylesheet" href="settings.css" />
  </head>
  <body>
    <div class="container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <img
            src="claim logo.png"
            alt="Logo"
            style="width: 100px; height: 100px; border-radius: 50%"
          />
          <h2>Fund Claimer</h2>
        </div>
        <nav class="sidebar-nav">
          <ul>
            <li>
              <a href="home-page(Lutho_Version).html"
                ><i class="fas fa-home"></i> Home</a
              >
            </li>
            <li>
              <a href="upload-Client.php"><i class="fas fa-file-alt"></i> My Application</a>
            </li>
            <li>
              <a href="status-updates.php"
                ><i class="fas fa-tasks"></i> Status Updates</a
              >
            </li>
            <li>
              <a href="account-details.php"
                ><i class="fas fa-user"></i> My Details</a
              >
            </li>
            <li>
              <a href="claim-history.php"
                ><i class="fas fa-history"></i> Claim History</a
              >
            </li>
            <li>
              <a href="search.php"><i class="fas fa-search"></i> Search</a>
            </li>
            <li>
              <a href="#" id="map-nav-link"><i class="fas fa-map"></i> Map</a>
            </li>
            <li class="active">
              <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </li>
          </ul>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="main-content">
        <header class="top-bar">
          <div class="notification-bell">
            <i class="fas fa-bell"></i>
          </div>
          <div class="user-profile">
            <img src="https://via.placeholder.com/40" alt="Profile" />
            <span>John Doe</span>
          </div>
        </header>

        <div class="settings-container">
          <div class="success-message" id="success-message"></div>
          <div class="error-message" id="error-message"></div>

          <div class="settings-section">
            <h3>Theme Settings</h3>
            <div class="settings-item">
              <span>Dark Mode</span>
              <label class="toggle-switch">
                <input type="checkbox" id="dark-mode-toggle" />
                <span class="toggle-slider"></span>
              </label>
            </div>
          </div>

          <div class="settings-section">
            <h3>Notification Preferences</h3>
            <div class="settings-item">
              <span>Email Notifications</span>
              <label class="toggle-switch">
                <input type="checkbox" id="email-notifications-toggle" />
                <span class="toggle-slider"></span>
              </label>
            </div>
            <div class="settings-item">
              <span>SMS Notifications</span>
              <label class="toggle-switch">
                <input type="checkbox" id="sms-notifications-toggle" />
                <span class="toggle-slider"></span>
              </label>
            </div>
            <div class="settings-item">
              <span>Notification Sound</span>
              <label class="toggle-switch">
                <input type="checkbox" id="notification-sound-toggle" />
                <span class="toggle-slider"></span>
              </label>
            </div>
          </div>

          <div class="settings-section">
            <h3>Accessibility</h3>
            <div class="settings-item">
              <span>Text Size</span>
              <select id="text-size-select">
                <option value="small">Small</option>
                <option value="medium" selected>Medium</option>
                <option value="large">Large</option>
              </select>
            </div>
          </div>

          <div class="settings-section">
            <h3>Account Management</h3>
            <button id="delete-account-btn" class="btn btn-danger">
              Delete Account
            </button>
          </div>

          <div class="settings-section">
          <h3>Terms & Conditions</h3>
          <button id="terms-btn" class="btn btn-primary">
            <i class="fas fa-file-contract"></i> View Terms & Conditions
          </button>
        </div>

        </div>
      </main>
    </div>

    <script src="settings.js"></script>
  </body>
</html>

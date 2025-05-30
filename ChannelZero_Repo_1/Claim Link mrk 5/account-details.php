<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Account Details - Fund Claimer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="side_nav.css" />
    <link rel="stylesheet" href="account-details.css" />
  </head>
  <body>
    <div class="container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <img
            src="claim logo.png" alt="Logo" style="width: 100px; height: 100px; border-radius: 50%"
          />
          <h2>Fund Claimer</h2>
        </div>
        <nav class="sidebar-nav">
          <ul>
          <li>
              <a href="home-page(Lutho_Version).html"><i class="fas fa-home"></i> Home</a>
            </li>
            <li>
              <a href="upload-Client.php"
                ><i class="fas fa-file-alt"></i> My Application</a
              >
            </li>
            <li>
              <a href="status-updates.php"
                ><i class="fas fa-tasks"></i> Status Updates</a
              >
            </li>
            <li class="active">
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
            <li>
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

        <div class="account-details-container">
          <div class="success-message" id="success-message"></div>
          <div class="error-message" id="error-message"></div>

          <div class="profile-section">
            <div class="profile-picture">
              <img
                src="https://via.placeholder.com/150"
                alt="Profile Picture"
                id="profile-preview"
              />
              <div class="edit-overlay">
                <i class="fas fa-camera"></i> Change Photo
              </div>
              <input
                type="file"
                id="profile-upload"
                accept="image/*"
                style="display: none"
              />
            </div>
            <div class="profile-info">
              <h2>John Doe</h2>
              <p>john.doe@example.com</p>
              <p>+1 234 567 8900</p>
            </div>
          </div>

          <div class="form-section">
            <h3>Personal Information</h3>
            <form id="personal-info-form">
              <div class="form-group">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name"  required />
              </div>
              <div class="form-group">
                <label for="email">Email Address</label>
                <input
                  type="email"
                  id="email"
                  
                  required
                />
              </div>
              <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone"  required />
              </div>
              <button type="submit" class="btn btn-primary">
                Save Changes
              </button>
            </form>
          </div>

          <div class="form-section">
            <h3>Change Password</h3>
            <form id="password-form">
              <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" required />
              </div>
              <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" required />
              </div>
              <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" required />
              </div>
              <button type="submit" class="btn btn-primary">
                Update Password
              </button>
            </form>
          </div>

          <div class="form-section security-section">
            <h3>Security Settings</h3>
            <div class="form-group">
              <label>
                Two-Factor Authentication
                <label class="toggle-switch">
                  <input type="checkbox" id="2fa-toggle" />
                  <span class="toggle-slider"></span>
                </label>
              </label>
            </div>

            <div class="login-activity">
              <h4>Recent Login Activity</h4>
              <div class="activity-item">
                <span>Login from Chrome on Windows</span>
                <span>Today, 10:30 AM</span>
              </div>
              <div class="activity-item">
                <span>Login from Safari on iPhone</span>
                <span>Yesterday, 3:45 PM</span>
              </div>
              <div class="activity-item">
                <span>Login from Firefox on Mac</span>
                <span>Mar 13, 2024, 9:15 AM</span>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script src="account-details.js"></script>
  </body>
</html>

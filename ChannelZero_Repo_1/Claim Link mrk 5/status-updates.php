<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Status Updates - Fund Claimer</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link rel="stylesheet" href="side_nav.css" />
    <link rel="stylesheet" href="status-updates.css" />
  </head>
  <body>
    <div class="container">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <img
            src="claim logo.png" alt="Logo" style="width: 100px; height: 100px; border-radius: 50%" />
          <h2>Fund Claimer</h2>
        </div>
        <nav class="sidebar-nav">
          <ul>
            <li>
              <a href="home-page(Lutho_Version).html"><i class="fas fa-home"></i> Home</a>
            </li>
            <li>
              <a href="upload-Client.php"><i class="fas fa-file-alt"></i> My Application</a>
            </li>
            <li class="active">
              <a href="status-updates.php"
                ><i class="fas fa-tasks"></i> Status Updates</a>
            </li>
            <li>
              <a href="account-details.php"
                ><i class="fas fa-user"></i> My Details</a>
            </li>
            <li>
              <a href="claim-history.php"
                ><i class="fas fa-history"></i> Claim History</a>
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
            <span class="notification-dot"></span>
          </div>
          <div class="user-profile">
            <img src="https://via.placeholder.com/40" alt="Profile" />
            <span>John Doe</span>
          </div>
        </header>

        <div class="status-updates-container">
          <h1>Status Updates</h1>

          <div class="filters-section">
            <div class="filter-group">
              <label for="status-filter">Status</label>
              <select id="status-filter">
                <option value="all">All Statuses</option>
                <option value="received">Received</option>
                <option value="review">Under Review</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
            <div class="filter-group">
              <label for="date-from">From Date</label>
              <input type="date" id="date-from" />
            </div>
            <div class="filter-group">
              <label for="date-to">To Date</label>
              <input type="date" id="date-to" />
            </div>
          </div>

          <div class="status-list" id="status-list">
            <!-- Status items will be dynamically added here -->
          </div>
        </div>
      </main>
    </div>

    <script src="status-updates.js"></script>
  </body>
</html>


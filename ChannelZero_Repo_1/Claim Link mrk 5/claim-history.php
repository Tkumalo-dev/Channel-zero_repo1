<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Claim History - Fund Claimer</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link rel="stylesheet" href="side_nav.css" />
    <link rel="stylesheet" href="claim-history.css" />
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
            <li>
              <a href="status-updates.php"
                ><i class="fas fa-tasks"></i> Status Updates</a>
            </li>
            <li>
              <a href="account-details.php"
                ><i class="fas fa-user"></i> My Details</a>
            </li>
            <li class="active">
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

        <div class="claim-history-container">
          <h1>Claim History</h1>

          <div class="search-box">
            <input
              type="text"
              id="search-input"
              placeholder="Search claims..."
            />
            <button id="search-button">
              <i class="fas fa-search"></i> Search
            </button>
          </div>

          <div class="filters-section">
            <div class="filter-group">
              <label for="status-filter">Status:</label>
              <select id="status-filter">
                <option value="all">All Statuses</option>
                <option value="received">Received</option>
                <option value="review">Under Review</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
              </select>
            </div>
            <div class="filter-group">
              <label for="date-from">From:</label>
              <input type="date" id="date-from" />
            </div>
            <div class="filter-group">
              <label for="date-to">To:</label>
              <input type="date" id="date-to" />
            </div>
          </div>

          <div class="claims-table">
            <table>
              <thead>
                <tr>
                  <th>Claim ID</th>
                  <th>Type</th>
                  <th>Submission Date</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="claims-table-body">
                <!-- Claims will be dynamically added here -->
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>

    <!-- Claim Details Modal -->
    <div id="claim-details-modal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Claim Details</h2>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body" id="claim-details-content">
          <!-- Claim details will be dynamically added here -->
        </div>
      </div>
    </div>

    <script src="claim-history.js"></script>
  </body>
</html>

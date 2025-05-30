<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Channel Zero - Dashboard</title>
    <link rel="stylesheet" href="dashboard(Lutho_Version).css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  </head>

  <body class="dark-mode">


    <div class="dashboard-container">
      <aside class="sidebar">
        <div class="sidebar-header">
          <img
            src="claim logo.png"
            alt="Channel Zero Logo"
            class="logo"
            style="width: 100px; height: 100px; border-radius: 50%"
          />
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
              <a href="status-updates.php"><i class="fas fa-tasks"></i> Status Updates</a>
            </li>
            <li>
              <a href="account-details.php"><i class="fas fa-user"></i> My Details</a>
            </li>
            <li>
              <a href="claim-history.php"><i class="fas fa-history"></i> Claim History</a>
            </li>
            <li>
              <a href="search.php"><i class="fas fa-search"></i> Search</a>
            </li>
            <li>
              <a href="map.html"><i class="fas fa-map"></i> Map</a>
            </li>

            <li>
              <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </li>
          </ul>
        </nav>
        <div class="sidebar-bottom">
          <div class="balance-info">
            <span>R315,00</span> <i class="fas fa-wallet"></i>
            <small>Last Updated Yesterday</small>
          </div>
        </div>
      </aside>

      <main class="main-content">
        <header class="main-header">
          <div class="welcome-user">
            <img
              src="profile picture.jpg"
              alt="User Avatar"
              class="user-avatar"
            />
            <div>
              <span>Welcome Back!</span>
              <h3>Mila Hlungulu</h3>
            </div>
          </div>
          <div class="header-icons">
            <i class="fas fa-bell"></i>
            <i class="fas fa-cog"></i>
          </div>
        </header>

        <div class="action-bar">
          <button class="btn-add-new">
            <i class="fas fa-plus"></i> Add new
          </button>
          <div class="date-range">
            <i class="fas fa-calendar-alt"></i> 11 Nov - 11 Dec, 2026
          </div>
          <div class="action-icons">
            <i class="fas fa-filter"></i>
            <a href="search.php"><i class="fas fa-search"></i></a>
          </div>
        </div>

        <!-- Dashboard Content -->
        <div id="dashboard-content" class="content-section">
          <div class="content-grid">
            <div class="card total-funds-card">
              <h5>Total Funds Claimed</h5>
              <h2>R9.385.34</h2>
              <div class="fund-icons">
                <span class="fund-icon"><i class="fas fa-university"></i></span>
                <span class="fund-icon"><i class="fas fa-piggy-bank"></i></span>
                <span class="fund-icon"><i class="fas fa-chart-line"></i></span>
                <span class="fund-icon"
                  ><i class="fas fa-file-invoice-dollar"></i
                ></span>
              </div>
            </div>

            <div class="card timeline-card">
              <h4>Claim Timeline</h4>
              <div class="timeline-controls">
                <i class="fas fa-chart-bar"></i>
                <i class="fas fa-search-plus"></i>
              </div>
              <div class="graph-placeholder">
                <img
                  src="placeholder-graph.png"
                  alt="Timeline Graph Placeholder"
                />
                <div class="timeline-info">
                  <span>$300.00</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Map Content Section -->
        <div class="content-grid">
          <div class="card map-card">
            <h4>Branches near you</h4>
            <p>We found 24 branches</p>
            <div id="dashboard-map" style="height: 250px; width: 100%; border-radius: 8px;"></div>
          </div>

    <!-- Add New Modal -->
    <div
      id="addNewModal"
      class="modal"
      style="
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
      "
    >
      <div
        style="
          background: #fff;
          padding: 20px;
          border-radius: 8px;
          max-width: 400px;
          width: 90%;
        "
      >
        <h3>Add New Claim</h3>
        <textarea
          id="newClaimText"
          rows="4"
          style="width: 100%"
          placeholder="Enter claim details here..."
        ></textarea>
        <div style="margin-top: 15px; text-align: right">
          <button id="cancelAddNew">Cancel</button>
          <button id="submitAddNew">Submit</button>
        </div>
      </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize the map
        const map = L.map('dashboard-map').setView([-26.2041, 28.0473], 13);

        // Add a tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add a marker example
        L.marker([-26.2041, 28.0473])
          .addTo(map)
          .bindPopup('Branch Location')
          .openPopup();

        // Map navigation toggle
        const mapNavLink = document.getElementById('map-nav-link');
        const dashboardContent = document.getElementById('dashboard-content');
        const mapContent = document.getElementById('map-content');

        mapNavLink.addEventListener('click', function(e) {
          e.preventDefault();
          dashboardContent.style.display = 'none';
          mapContent.style.display = 'block';
          // Trigger map resize to ensure proper rendering
          setTimeout(() => {
            map.invalidateSize();
          }, 100);
        });
      });
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="dashboard(Lutho_Version).js"></script>
    <script src="search.js"></script>
  </body>
</html>

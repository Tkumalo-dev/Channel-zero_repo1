<?php
// dashboard(Lutho_Version).php
session_start();
require 'db_connect.php';

// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Session security
session_regenerate_id(true);
if (isset($_SESSION['user_agent'])) {
    if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_destroy();
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
}

try {
    // Get user data from database
    $user_id = $_SESSION['user_id'];
    $user_query = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $user_query->bind_param("i", $user_id);
    $user_query->execute();
    $result = $user_query->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("User account not found");
    }
    $user = $result->fetch_assoc();

    // Get claim statistics with proper table joins and COALESCE to handle NULL values
    $claims_query = $conn->prepare("
        SELECT 
            COUNT(c.claim_id) as total_claims,
            COALESCE(SUM(uf.amount), 0) as total_amount,
            COALESCE(SUM(CASE WHEN c.status = 'paid' THEN uf.amount ELSE 0 END), 0) as paid_amount
        FROM claims c
        JOIN unclaimed_funds uf ON c.fund_id = uf.fund_id
        WHERE c.user_id = ?
    ");
    $claims_query->bind_param("i", $user_id);
    $claims_query->execute();
    $stats = $claims_query->get_result()->fetch_assoc();
    
    // Ensure stats array exists with default values
    $stats = $stats ?: [
        'total_claims' => 0,
        'total_amount' => 0,
        'paid_amount' => 0
    ];

    // Convert all numeric values to float to ensure proper formatting
    $stats = array_map(function($value) {
        return is_numeric($value) ? (float)$value : 0;
    }, $stats);

} catch (mysqli_sql_exception $e) {
    error_log("Database error: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
} catch (Exception $e) {
    error_log("Application error: " . $e->getMessage());
    die($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com/ajax/libs https://kit.fontawesome.com; style-src 'self' https://fonts.googleapis.com https://cdnjs.cloudflare.com 'unsafe-inline'; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data:;">
    <title>Channel Zero - Dashboard</title>
    <link rel="stylesheet" href="dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body class="dark-mode">
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="claim logo.png" alt="Channel Zero Logo" class="logo" style="width: 100px; height: 100px; border-radius: 50%" />
                <h2>Fund Claimer</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active">
                        <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-file-alt"></i> My Application</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-tasks"></i> Status Updates</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-user"></i> My Details</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-history"></i> Claim History</a>
                    </li>
                    <li>
                        <a href="search.php"><i class="fas fa-search"></i> Search</a>
                    </li>
                    <li>
                        <a href="#" id="map-nav-link"><i class="fas fa-map"></i> Map</a>
                    </li>
                    <li>
                        <a href="#"><i class="fas fa-cog"></i> Settings</a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-bottom">
                <div class="balance-info">
                    <span>R<?php echo number_format($stats['paid_amount'], 2); ?></span>
                    <i class="fas fa-wallet"></i>
                    <small>Last Updated <?php echo date('Y-m-d'); ?></small>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <div class="welcome-user">
                    <img src="profile picture.jpg" alt="User Avatar" class="user-avatar" />
                    <div>
                        <span>Welcome Back!</span>
                        <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h3>
                    </div>
                </div>
                <div class="header-icons">
                    <i class="fas fa-bell"></i>
                    <a href="settings.php"><i class="fas fa-cog"></i></a>
                </div>
            </header>

            <div class="action-bar">
                <button class="btn-add-new">
                    <i class="fas fa-plus"></i> Add new
                </button>
                <div class="date-range">
                    <i class="fas fa-calendar-alt"></i> <?php echo date('d M - d M, Y'); ?>
                </div>
                <div class="action-icons">
                    <i class="fas fa-filter"></i>
                    <a href="search.php"><i class="fas fa-search"></i></a>
                </div>
            </div>

            <div id="dashboard-content" class="content-section">
                <div class="content-grid">
                    <div class="card card-details">
                        <div class="bank-name">
                            <span>Gauteng Bank</span>
                        </div>
                        <img src="chip.png" alt="credit card chip" style="width: 50px; height: 50px" /><br /><br />
                        <div class="card-chip">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <div class="card-number"><?php echo isset($user['id_number']) ? substr(htmlspecialchars($user['id_number']), 0, 10) . ' XXXX' : 'XXXX XXXX XXXX'; ?></div>
                        <div class="card-holder-info">
                            <small>Card Holder</small>
                            <span><?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></span>
                        </div>
                        <div class="card-expiry">
                            <small>Valid Until</small>
                            <span><?php echo date('m/y', strtotime('+3 years')); ?></span>
                        </div>
                        <i class="fa-brands fa-cc-mastercard"></i>
                    </div>

                    <div class="card total-funds-card">
                        <h5>Total Funds Claimed</h5>
                        <h2>R<?php echo number_format($stats['total_amount'], 2); ?></h2>
                        <div class="fund-icons">
                            <span class="fund-icon"><i class="fas fa-university"></i></span>
                            <span class="fund-icon"><i class="fas fa-piggy-bank"></i></span>
                            <span class="fund-icon"><i class="fas fa-chart-line"></i></span>
                            <span class="fund-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                        </div>
                    </div>

                    <div class="card timeline-card">
                        <h4>Claim Timeline</h4>
                        <div class="timeline-controls">
                            <i class="fas fa-chart-bar"></i>
                            <i class="fas fa-search-plus"></i>
                        </div>
                        <div class="graph-placeholder">
                            <img src="placeholder-graph.png" alt="Timeline Graph Placeholder" loading="lazy" />
                            <div class="timeline-info">
                                <span>R<?php echo number_format($stats['paid_amount'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="map-content" class="content-section" style="display: none">
                <div class="card full-width-card">
                    <h4>ATMs On The Map</h4>
                    <p>We found <span id="atm-count">24</span> ATM</p>
                    <div class="map-placeholder" style="position: relative; height: 500px">
                        <img src="placeholder-map.png" alt="Map Placeholder" style="width: 100%; height: 100%; object-fit: cover" loading="lazy" />
                        <button style="position: absolute; right: 20px; top: 20px; background: #2e86de; color: white; border: none; padding: 10px 15px; border-radius: 6px; cursor: pointer; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); font-weight: bold;">
                            Filters
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add New Modal -->
    <div id="addNewModal" class="modal" style="display: none">
        <div class="modal-content">
            <h3>Add New Claim</h3>
            <textarea id="newClaimText" rows="4" placeholder="Enter claim details here..."></textarea>
            <div class="modal-actions">
                <button id="cancelAddNew">Cancel</button>
                <button id="submitAddNew">Submit</button>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="dashboard.js"></script>
    <script src="search.js"></script>
</body>
</html>
<?php
session_start();
require 'db_connect.php';

$search_results = [];
$search_performed = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $id_number = trim($_POST['id_number'] ?? '');

    // Basic validation
    if (!empty($first_name) && !empty($last_name)) {
        $search_performed = true;
        
        // Prepare search query
        $query = "SELECT uf.*, c.name as company_name 
                 FROM unclaimed_funds uf
                 JOIN companies c ON uf.company_id = c.company_id
                 WHERE uf.beneficiary_name LIKE ? 
                 OR uf.beneficiary_id = ?";
        
        $stmt = $conn->prepare($query);
        $name_search = "%$first_name% $last_name%";
        $stmt->bind_param("ss", $name_search, $id_number);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $search_results = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Unclaimed Funds Search</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="search.css">
</head>
<body class="light-mode">

  <main class="container <?php echo $search_performed ? 'split' : 'initial'; ?>">
    
    <section class="search-section">
      <div class="icon-wrap">
        <i class="fas fa-piggy-bank"></i>
      </div>
      <h2>🔎 Search Your Name</h2>
      <p class="subtitle">Find out if you're owed money</p>
      <form id="funds-form" method="POST">
        <div class="form-group">
          <input type="text" id="first-name" name="first_name" required 
                 value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" />
          <label for="first-name">First Name</label>
        </div>

        <div class="form-group">
          <input type="text" id="last-name" name="last_name" required 
                 value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" />
          <label for="last-name">Last Name</label>
        </div>

        <div class="form-group">
          <input type="date" id="dob" name="dob" required 
                 value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>" />
          <label for="dob">Date of Birth</label>
        </div>

        <div class="form-group">
          <input type="text" id="idnum" name="id_number" required 
                 value="<?php echo htmlspecialchars($_POST['id_number'] ?? ''); ?>" />
          <label for="idnum">ID Number</label>
        </div>

        <button type="submit" class="btn-submit">Check Now</button>
        <div class="loader" id="loader" style="display: none;"></div>
        <button type="button" id="reset-btn" class="btn-reset" 
                style="<?php echo $search_performed ? '' : 'display: none;' ?>">Reset</button>
      </form>
    </section>

    <section class="results-section" id="results-section">
      <h2>Search Results</h2>
      <div id="fund-result" class="fund-result">
        <?php if ($search_performed): ?>
          <?php if (!empty($search_results)): ?>
            <?php foreach ($search_results as $fund): ?>
              <div class="fund-card">
                <p><strong>Institution:</strong> <?php echo htmlspecialchars($fund['company_name']); ?></p>
                <p><strong>Amount:</strong> R<?php echo number_format($fund['amount'], 2); ?></p>
                <p><strong>Type:</strong> <?php echo htmlspecialchars(ucfirst($fund['type'])); ?></p>
                <p><strong>Reported:</strong> <?php echo date('d M Y', strtotime($fund['date_reported'])); ?></p>
                <form method="POST" action="claim.php" style="margin-top: 10px;">
                  <input type="hidden" name="fund_id" value="<?php echo $fund['fund_id']; ?>">
                  <button type="submit" class="claim-btn">Claim This Amount</button>
                </form>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="fund-card">
              <p style="color: #e74a3b;">No unclaimed funds found matching your search.</p>
              <p>Try different name variations or check back later.</p>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </section>

  </main>

  <script src="search.js"></script>
</body>
</html>

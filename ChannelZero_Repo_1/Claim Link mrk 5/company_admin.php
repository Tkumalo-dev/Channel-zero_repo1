


 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Admin - Claims Verification</title>
    <link rel="stylesheet" href="company_admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="logo">
                <img src="claim logo.png" alt="Claim Link Logo">
                <h2>Company Admin</h2>
            </div>
            <ul class="nav-menu">
                <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#pending-claims"><i class="fas fa-clock"></i> Pending Claims</a></li>
                <li><a href="#verified-claims"><i class="fas fa-check-circle"></i> Verified Claims</a></li>
                <li><a href="#rejected-claims"><i class="fas fa-times-circle"></i> Rejected Claims</a></li>
                <li><a href="upload-business.php"><i class="fas fa-users"></i> Upload Database</a></li>
            </ul>
            <div class="logout">
                <a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        
        <div class="main-content">
            <div class="header">
                <div class="search-bar">
                    <input type="text" placeholder="Search claims...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="admin-profile">
                    <span>Welcome, Admin</span>
                    <img src="profile picture.jpg" alt="Admin Profile">
                </div>
            </div>
            
            <div class="dashboard-summary">
                <div class="card">
                    <div class="card-inner">
                        <h3>Total Claims</h3>
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h1>48</h1>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <h3>Pending</h3>
                        <i class="fas fa-clock"></i>
                    </div>
                    <h1>16</h1>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <h3>Verified</h3>
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h1>27</h1>
                </div>
                <div class="card">
                    <div class="card-inner">
                        <h3>Rejected</h3>
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <h1>5</h1>
                </div>
            </div>
            
            
            <div class="section" id="pending-claims">
                <h2>Pending Claims</h2>
                <div class="claims-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Claim ID</th>
                                <th>User</th>
                                <th>Business</th>
                                <th>Date Submitted</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample claims data (would normally come from database)
                            $pendingClaims = [
                                ['id' => 'CLM-1001', 'user' => 'John Doe', 'business' => 'ABC Insurance', 'date' => '2023-11-15', 'amount' => '$1,200.00', 'status' => 'Pending'],
                                ['id' => 'CLM-1002', 'user' => 'Jane Smith', 'business' => 'XYZ Corp', 'date' => '2023-11-14', 'amount' => '$850.75', 'status' => 'Pending'],
                                ['id' => 'CLM-1003', 'user' => 'Robert Johnson', 'business' => 'Acme Ltd', 'date' => '2023-11-13', 'amount' => '$2,340.50', 'status' => 'Pending'],
                            ];
                            
                            foreach ($pendingClaims as $claim) {
                                echo "<tr>";
                                echo "<td>{$claim['id']}</td>";
                                echo "<td>{$claim['user']}</td>";
                                echo "<td>{$claim['business']}</td>";
                                echo "<td>{$claim['date']}</td>";
                                echo "<td>{$claim['amount']}</td>";
                                echo "<td><span class='status pending'>{$claim['status']}</span></td>";
                                echo "<td class='actions'>";
                                echo "<button class='btn view' onclick='viewClaim(\"{$claim['id']}\")'><i class='fas fa-eye'></i></button>";
                                echo "<button class='btn approve' onclick='approveClaim(\"{$claim['id']}\")'><i class='fas fa-check'></i></button>";
                                echo "<button class='btn reject' onclick='rejectClaim(\"{$claim['id']}\")'><i class='fas fa-times'></i></button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section" id="verified-claims">
                <h2>Verified Claims</h2>
                <div class="claims-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Claim ID</th>
                                <th>User</th>
                                <th>Business</th>
                                <th>Date Submitted</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample verified claims data
                            $verifiedClaims = [
                                ['id' => 'CLM-1004', 'user' => 'Alice Brown', 'business' => 'Delta Inc', 'date' => '2023-11-10', 'amount' => '$1,500.00', 'status' => 'Verified'],
                                ['id' => 'CLM-1005', 'user' => 'Chris Green', 'business' => 'Omega LLC', 'date' => '2023-11-09', 'amount' => '$2,100.00', 'status' => 'Verified'],
                            ];
                            
                            foreach ($verifiedClaims as $claim) {
                                echo "<tr>";
                                echo "<td>{$claim['id']}</td>";
                                echo "<td>{$claim['user']}</td>";
                                echo "<td>{$claim['business']}</td>";
                                echo "<td>{$claim['date']}</td>";
                                echo "<td>{$claim['amount']}</td>";
                                echo "<td><span class='status verified'>{$claim['status']}</span></td>";
                                echo "<td class='actions'>";
                                echo "<button class='btn view' onclick='viewClaim(\"{$claim['id']}\")'><i class='fas fa-eye'></i></button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section" id="rejected-claims">
                <h2>Rejected Claims</h2>
                <div class="claims-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Claim ID</th>
                                <th>User</th>
                                <th>Business</th>
                                <th>Date Submitted</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample rejected claims data
                            $rejectedClaims = [
                                ['id' => 'CLM-1006', 'user' => 'Emily White', 'business' => 'Beta Corp', 'date' => '2023-11-08', 'amount' => '$900.00', 'status' => 'Rejected'],
                                ['id' => 'CLM-1007', 'user' => 'David Black', 'business' => 'Gamma Ltd', 'date' => '2023-11-07', 'amount' => '$1,250.00', 'status' => 'Rejected'],
                            ];
                            
                            foreach ($rejectedClaims as $claim) {
                                echo "<tr>";
                                echo "<td>{$claim['id']}</td>";
                                echo "<td>{$claim['user']}</td>";
                                echo "<td>{$claim['business']}</td>";
                                echo "<td>{$claim['date']}</td>";
                                echo "<td>{$claim['amount']}</td>";
                                echo "<td><span class='status rejected'>{$claim['status']}</span></td>";
                                echo "<td class='actions'>";
                                echo "<button class='btn view' onclick='viewClaim(\"{$claim['id']}\")'><i class='fas fa-eye'></i></button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="section" id="claim-details-modal">
                <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <h2>Claim Details</h2>
                    <div id="claim-details-content">
                        <!-- Content will be loaded dynamically -->
                    </div>
                    <div class="claim-documents">
                        <h3>Supporting Documents</h3>
                        <div class="document-list">
                            <div class="document">
                                <i class="fas fa-file-pdf"></i>
                                <span>Medical_Report.pdf</span>
                                <button class="btn view-doc"><i class="fas fa-eye"></i></button>
                                <button class="btn download-doc"><i class="fas fa-download"></i></button>
                            </div>
                            <div class="document">
                                <i class="fas fa-file-image"></i>
                                <span>Receipt_Photo.jpg</span>
                                <button class="btn view-doc"><i class="fas fa-eye"></i></button>
                                <button class="btn download-doc"><i class="fas fa-download"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="verification-form">
                        <h3>Verification Decision</h3>
                        <form id="verify-claim-form">
                            <div class="form-group">
                                <label for="verification-status">Status:</label>
                                <select id="verification-status" name="status">
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                    <option value="more-info">Request More Information</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="verification-notes">Notes:</label>
                                <textarea id="verification-notes" name="notes" placeholder="Enter verification notes..."></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn submit-verification">Submit Decision</button>
                                <button type="button" class="btn cancel-verification">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="company_admin.js"></script>
</body>
</html>

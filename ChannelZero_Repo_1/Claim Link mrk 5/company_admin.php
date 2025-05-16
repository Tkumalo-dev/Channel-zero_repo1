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
                <h2>Claim Link</h2>
            </div>
            <ul class="nav-menu">
                <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#pending-claims"><i class="fas fa-clock"></i> Pending Claims</a></li>
                <li><a href="#verified-claims"><i class="fas fa-check-circle"></i> Verified Claims</a></li>
                <li><a href="#rejected-claims"><i class="fas fa-times-circle"></i> Rejected Claims</a></li>
                <li><a href="#user-management"><i class="fas fa-users"></i> User Management</a></li>
                <li><a href="#settings"><i class="fas fa-cog"></i> Settings</a></li>
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
            
            <!-- File Upload Section -->
            <div class="section" id="file-upload-section">
                <h2>Upload Files</h2>
                <div class="upload-container">
                    <div class="upload-types">
                        <div class="upload-type active" data-type="csv">
                            <i class="fas fa-file-csv"></i>
                            <span>CSV Files</span>
                        </div>
                        <div class="upload-type" data-type="documents">
                            <i class="fas fa-file-pdf"></i>
                            <span>Documents</span>
                        </div>
                        <div class="upload-type" data-type="images">
                            <i class="fas fa-file-image"></i>
                            <span>Images</span>
                        </div>
                    </div>
                    
                    <div class="upload-area" id="csvUpload">
                        <form action="process_upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
                            <div class="simple-upload">
                                <div class="file-selection">
                                    <label for="fileInput" class="file-label">
                                        <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon">
                                        <span>Choose a file or drag it here</span>
                                    </label>
                                    <input type="file" id="fileInput" name="file" class="file-input">
                                </div>
                                
                                <div id="fileInfo" class="file-info" style="display: none;">
                                    <div class="selected-file-info">
                                        <i class="fas fa-file"></i>
                                        <span id="selectedFileName">No file selected</span>
                                    </div>
                                    <button type="button" id="removeFile" class="btn remove-btn">
                                        <i class="fas fa-times"></i> Remove
                                    </button>
                                </div>
                                
                                <div class="upload-button-container">
                                    <button type="submit" class="btn submit-btn">Upload File</button>
                                </div>
                            </div>
                        </form>
                    </div>
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

    <script>
        // JavaScript to handle claim verification
        function viewClaim(claimId) {
            // In a real application, this would fetch claim details from the database
            document.getElementById('claim-details-modal').style.display = 'block';
            
            // Populate claim details
            const claimDetailsContent = document.getElementById('claim-details-content');
            claimDetailsContent.innerHTML = `
                <div class="claim-detail-row">
                    <span class="detail-label">Claim ID:</span>
                    <span class="detail-value">${claimId}</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Submitted By:</span>
                    <span class="detail-value">John Doe</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Business:</span>
                    <span class="detail-value">ABC Insurance</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Date Submitted:</span>
                    <span class="detail-value">2023-11-15</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Claim Amount:</span>
                    <span class="detail-value">$1,200.00</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Description:</span>
                    <span class="detail-value">Medical expenses for treatment received on November 10, 2023. Includes consultation fee and medication costs.</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Contact Email:</span>
                    <span class="detail-value">john.doe@example.com</span>
                </div>
                <div class="claim-detail-row">
                    <span class="detail-label">Contact Phone:</span>
                    <span class="detail-value">+1 (555) 123-4567</span>
                </div>
            `;
        }
        
        function approveClaim(claimId) {
            if (confirm(`Are you sure you want to approve claim ${claimId}?`)) {
                // In a real application, this would update the database
                alert(`Claim ${claimId} has been approved`);
                // Refresh the page or update the UI
            }
        }
        
        function rejectClaim(claimId) {
            if (confirm(`Are you sure you want to reject claim ${claimId}?`)) {
                // In a real application, this would update the database
                alert(`Claim ${claimId} has been rejected`);
                // Refresh the page or update the UI
            }
        }
        
        // Close modal
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('claim-details-modal').style.display = 'none';
        });
        
        // Cancel verification
        document.querySelector('.cancel-verification').addEventListener('click', function() {
            document.getElementById('claim-details-modal').style.display = 'none';
        });
        
        // Submit verification form
        document.getElementById('verify-claim-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const status = document.getElementById('verification-status').value;
            const notes = document.getElementById('verification-notes').value;
            
            // In a real application, this would update the database
            alert(`Claim verification submitted with status: ${status}`);
            document.getElementById('claim-details-modal').style.display = 'none';
        });
        
        // File Upload Functionality - Simplified Version
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const fileInfo = document.getElementById('fileInfo');
            const selectedFileName = document.getElementById('selectedFileName');
            const removeFileBtn = document.getElementById('removeFile');
            const uploadTypes = document.querySelectorAll('.upload-type');
            
            // Handle file selection
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    selectedFileName.textContent = this.files[0].name;
                    fileInfo.style.display = 'flex';
                } else {
                    fileInfo.style.display = 'none';
                }
            });
            
            // Remove selected file
            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                fileInfo.style.display = 'none';
            });
            
            // Switch between upload types
            uploadTypes.forEach(type => {
                type.addEventListener('click', function() {
                    uploadTypes.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Change accept attribute based on the selected type
                    if (this.dataset.type === 'csv') {
                        fileInput.setAttribute('accept', '.csv');
                    } else if (this.dataset.type === 'documents') {
                        fileInput.setAttribute('accept', '.pdf,.doc,.docx');
                    } else if (this.dataset.type === 'images') {
                        fileInput.setAttribute('accept', '.jpg,.jpeg,.png');
                    }
                });
            });
            
            // Drag and drop functionality
            const dropArea = document.querySelector('.file-label');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('highlight');
            }
            
            function unhighlight() {
                dropArea.classList.remove('highlight');
            }
            
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length > 0) {
                    fileInput.files = files;
                    selectedFileName.textContent = files[0].name;
                    fileInfo.style.display = 'flex';
                }
            }
        });
    </script>
</body>
</html>

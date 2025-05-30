// JavaScript to handle claim verification
function viewClaim(claimId) {
    // In a real application, this would fetch claim details from the database
    document.getElementById("claim-details-modal").style.display = "block";
  
    // Populate claim details
    const claimDetailsContent = document.getElementById("claim-details-content");
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
  document.querySelector(".close-modal").addEventListener("click", function () {
    document.getElementById("claim-details-modal").style.display = "none";
  });
  
  // Cancel verification
  document
    .querySelector(".cancel-verification")
    .addEventListener("click", function () {
      document.getElementById("claim-details-modal").style.display = "none";
    });
  
  // Submit verification form
  document
    .getElementById("verify-claim-form")
    .addEventListener("submit", function (e) {
      e.preventDefault();
      const status = document.getElementById("verification-status").value;
      const notes = document.getElementById("verification-notes").value;
  
      // In a real application, this would update the database
      alert(`Claim verification submitted with status: ${status}`);
      document.getElementById("claim-details-modal").style.display = "none";
    });
  
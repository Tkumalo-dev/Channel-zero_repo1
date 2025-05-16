<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Claim Documents</title>
    <link rel="stylesheet" href="upload-Client.css" />
  </head>
  <body>
    <div class="container">
      <header>
        <div class="logo-title">
          <div class="logo">Upload</div>
          <h1>Upload Claim Documents</h1>
        </div>
        <p class="subtitle">
          Please upload all required documents to process your claim.
        </p>
      </header>

      <main>
        <form id="uploadForm">
          <div class="upload-area" id="idUpload">
            <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon" />
            <span>Upload ID Document</span>
            <input type="file" id="idInput" accept=".pdf,.jpg,.jpeg,.png" hidden
            />
          </div>

          <div class="upload-area" id="policyUpload">
            <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon" />
            <span>Upload Policy Document</span>
            <input
              type="file"
              id="policyInput"
              accept=".pdf,.jpg,.jpeg,.png"
              hidden
            />
          </div>

          <div class="upload-area" id="deathCertUpload">
            <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon" />
            <span>Upload Death Certificate</span>
            <input
              type="file"
              id="deathCertInput"
              accept=".pdf,.jpg,.jpeg,.png"
              hidden
            />
          </div>

          <div class="form-group">
            <input type="text" id="fullName" placeholder="Full Name" required />
          </div>

          <div class="form-group">
            <input
              type="text"
              id="relationship"
              placeholder="Relationship to Deceased"
              required
            />
          </div>

          <div class="form-group">
            <input
              type="email"
              id="email"
              placeholder="Email Address"
              required
            />
            <span class="error-message" id="emailError"
              >Please enter valid email address</span
            >
          </div>

          <div class="form-group">
            <input type="tel" id="phone" placeholder="Phone Number" required />
          </div>

          <div class="form-actions">
            <button type="button" id="saveDraft" class="secondary-btn">
              Save Draft
            </button>
            <button type="submit" class="primary-btn">Submit</button>
          </div>

          <div class="consent-checkbox">
            <input type="checkbox" id="consent" required />
            <label for="consent"
              >I confirm that all documents provided are authentic and I am
              authorized to submit this claim.</label
            >
          </div>
        </form>

        <div id="trackingInfo" class="tracking-section hidden">
          <h2>Claim Tracking</h2>
          <p>Tracking ID: <span id="trackingId"></span></p>
          <p>Status: <span id="claimStatus"></span></p>
        </div>
      </main>
    </div>
    <script src="upload-Client.js"></script>
  </body>
</html>

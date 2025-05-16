<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Unclaimed Funds Records</title>
    <link rel="stylesheet" href="upload-Business.css" />
  </head>
  <body>
    <div class="container">
      <header>
        <div class="logo-title">
          <div class="logo">Upload</div>
          <h1>Unclaimed Funds Records</h1>
        </div>
        <p class="subtitle">
          Use the form below to securely upload your database of unclaimed
          funds.
        </p>
      </header>

      <main>
        <form id="uploadForm">
          <div class="upload-area" id="dropZone">
            <img src="upload-icon.svg" alt="Upload Icon" class="upload-icon" />
            <span>Upload CSV File</span>
            <input type="file" id="fileInput" accept=".CSV" hidden />
          </div>

          <div class="form-group">
            <input
              type="text"
              id="companyName"
              placeholder="Company Name"
              required
            />
          </div>

          <div class="form-group">
            <input
              type="text"
              id="contactPerson"
              placeholder="Contact Person Name"
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

          <div class="form-actions">
            <button type="button" id="saveDraft" class="secondary-btn">
              Save Draft
            </button>
            <button type="submit" class="primary-btn">Submit</button>
          </div>

          <div class="consent-checkbox">
            <input type="checkbox" id="consent" required />
            <label for="consent"
              >I confirm that I am authorized to share this data and consent to
              its use for helping individuals claim their funds.</label
            >
          </div>
        </form>

        <div id="trackingInfo" class="tracking-section hidden">
          <h2>Document Tracking</h2>
          <p>Tracking ID: <span id="trackingId"></span></p>
          <p>Status: <span id="documentStatus"></span></p>
        </div>
      </main>
    </div>
    <script src="upload-Business.js"></script>
  </body>
</html>

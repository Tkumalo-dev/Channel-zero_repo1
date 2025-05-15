<?php

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
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f6f9;
      color: #333;
      height: 100%;
      scroll-behavior: smooth;
    }

    body {
      padding: 40px 20px;
    }

    .container {
      display: flex;
      align-items: flex-start;
      transition: all 0.4s ease;
    }

    .container.initial {
      justify-content: center;
    }

    .container.initial .results-section {
      display: none;
    }

    .container.split {
      justify-content: space-between;
    }

    .container.split .results-section {
      display: block;
      flex: 1;
      margin-left: 40px;
    }

    .search-section {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      max-width: 500px;
      flex: 1;
    }

    .search-section h2 {
      text-align: center;
      color: #4e73df;
      margin-bottom: 20px;
    }

    .icon-wrap {
      text-align: center;
      font-size: 40px;
      color: #4e73df;
      margin-bottom: 15px;
    }

    .form-group {
      position: relative;
      margin-bottom: 20px;
    }

    .form-group input {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      border: 2px solid #ccc;
      border-radius: 6px;
    }

    .form-group label {
      position: absolute;
      top: -10px;
      left: 12px;
      background-color: white;
      font-size: 14px;
      color: #555;
      padding: 0 4px;
    }

    .btn-submit, .btn-reset {
      width: 100%;
      padding: 14px;
      font-size: 18px;
      background-color: #4e73df;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
      margin-top: 10px;
    }

    .btn-reset {
      background-color: #6c757d;
    }

    .btn-submit:hover {
      background-color: #3751e0;
    }

    .btn-reset:hover {
      background-color: #555;
    }

    .loader {
      margin: 20px auto;
      border: 5px solid #f3f3f3;
      border-top: 5px solid #4e73df;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .results-section {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 500px;
    }

    .results-section h2 {
      font-size: 1.5rem;
      color: #4e73df;
      margin-bottom: 20px;
    }

    .fund-result {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .fund-card {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      background-color: #f8f9fc;
    }

    .fund-card p {
      margin: 5px 0;
    }

    .claim-btn {
      margin-top: 10px;
      padding: 10px 14px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
    }

    .claim-btn:hover {
      background-color: #218838;
    }

    .subtitle {
      font-size: 1rem;
      color: #6c757d;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body class="light-mode">

  <main class="container initial">
    
    <section class="search-section">
      <div class="icon-wrap">
        <i class="fas fa-piggy-bank"></i>
      </div>
      <h2>🔎 Search Your Name</h2>
      <p class="subtitle">Find out if you're owed money</p>
      <form id="funds-form">
        <div class="form-group">
          <input type="text" id="first-name" required />
          <label for="first-name">First Name</label>
        </div>

        <div class="form-group">
          <input type="text" id="last-name" required />
          <label for="last-name">Last Name</label>
        </div>

        <div class="form-group">
          <input type="date" id="dob" required />
          <label for="dob">Date of Birth</label>
        </div>

        <div class="form-group">
          <input type="text" id="idnum" required />
          <label for="idnum">ID Number</label>
        </div>

        <button type="submit" class="btn-submit">Check Now</button>
        <div class="loader" id="loader" style="display: none;"></div>
        <button type="button" id="reset-btn" class="btn-reset" style="display: none;">Reset</button>
      </form>
    </section>

    <section class="results-section" id="results-section">
      <h2>Search Results</h2>
      <div id="fund-result" class="fund-result"></div>
    </section>

  </main>

  <script src="search.js"></script>
</body>
</html>

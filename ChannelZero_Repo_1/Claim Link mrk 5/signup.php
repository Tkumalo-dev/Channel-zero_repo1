<?php
// Include the Google API PHP Client Library
// require_once 'vendor/autoload.php';

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Google\Service\Oauth2 as Google_Service_Oauth2;

// Load google.env
$dotenv = Dotenv::createImmutable(__DIR__, 'google.env'); // Specify google.env
$dotenv->load();

$clientID = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? '';

$client = new Google\Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  echo "<pre>";
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  // now you can use this profile info to create account in your website and make user logged in.
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="signup.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign-up page</title>
</head>

<body>
  <div class="container">
    <div class="form-container">
      <div class="form-box" id="signup-form">
        <!-- From Uiverse.io by R1SH4BH81 -->
        <form class="form" method="POST" action="create_account.php">
          <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message" style="color: #ff0000; background-color: #ffe6e6; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #ff9999;">
              <?php
              echo htmlspecialchars($_SESSION['error']);
              unset($_SESSION['error']);
              ?>
            </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['success'])): ?>
            <div class="success-message" style="color: #008000; background-color: #e6ffe6; padding: 10px; margin-bottom: 15px; border-radius: 5px; border: 1px solid #99ff99;">
              <?php
              echo htmlspecialchars($_SESSION['success']);
              unset($_SESSION['success']);
              ?>
            </div>
          <?php endif; ?>

          <div class="flex-column">
            <label>First Name </label>
          </div>
          <div class="inputForm">
            <svg
              height="60"
              viewBox="0 -9 32 32"
              width="40"
              xmlns="http://www.w3.org/2000/svg">
              <g id="Layer_3" data-name="Layer 3">
                <path
                  d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"></path>
              </g>
            </svg>
            <input type="text" class="input" name="first_name" placeholder="Enter your First Name" required />
          </div>

          <div class="flex-column">
            <label>Last Name </label>
          </div>
          <div class="inputForm">
            <svg
              height="60"
              viewBox="0 -9 32 32"
              width="40"
              xmlns="http://www.w3.org/2000/svg">
              <g id="Layer_3" data-name="Layer 3">
                <path
                  d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"></path>
              </g>
            </svg>
            <input type="text" class="input" name="last_name" placeholder="Enter your Last Name" required />
          </div>

          <div class="flex-column">
            <label>Email </label>
          </div>
          <div class="inputForm">
            <svg
              height="20"
              viewBox="0 0 32 32"
              width="20"
              xmlns="http://www.w3.org/2000/svg">
              <g id="Layer_3" data-name="Layer 3">
                <path
                  d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path>
              </g>
            </svg>
            <input type="text" class="input" name="email" placeholder="Enter your Email" required />
          </div>

          <div class="flex-column">
            <label>Username </label>
          </div>
          <div class="inputForm">
            <svg
              height="20"
              viewBox="0 0 32 32"
              width="20"
              xmlns="http://www.w3.org/2000/svg">
              <g id="Layer_3" data-name="Layer 3">
                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"></path>
              </g>
            </svg>
            <input type="text" class="input" name="username" placeholder="Choose a username" required />
          </div>

          <div class="flex-column">
            <label>Password </label>
          </div>
          <div class="inputForm">
            <svg
              height="20"
              viewBox="-64 0 512 512"
              width="20"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
              <path
                d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
            </svg>
            <input type="password" class="input" name="password" placeholder="Enter your Password" required />
          </div>

          <div class="flex-column">
            <label>Confirm Password </label>
          </div>
          <div class="inputForm">
            <svg
              height="20"
              viewBox="-64 0 512 512"
              width="20"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
              <path
                d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
            </svg>
            <input type="password" class="input" name="confirm_password" placeholder="Confirm your Password" required />
          </div>

          <div></div>

          <?php

          echo "<a href=\"" . $client->createAuthUrl() . "\" class=\"btn google\" style=\"text-decoration:none;display:inline-block;\">
          
            <div id=\"google-icon-wrapper\" style=\"display: flex; align-items: center; justify-content: center; gap: 8px; margin: 10px auto 0 auto; color: #111; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 16px; padding-top: 5px;\">
                <svg
                  version=\"1.1\"
                  width=\"20\"
                  id=\"Layer_1\"
                  xmlns=\"http://www.w3.org/2000/svg\"
                  xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                  x=\"0px\"
                  y=\"0px\"
                  viewBox=\"0 0 512 512\"
                  style=\"enable-background:new 0 0 512 512;\"
                  xml:space=\"preserve\"
                >
                  <path
                    style=\"fill:#FBBB00;\"
                    d=\"M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
            c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
            C103.821,274.792,107.225,292.797,113.47,309.408z\"
                  ></path>
                  <path
                    style=\"fill:#518EF8;\"
                    d=\"M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
            c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
            c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z\"
                  ></path>
                  <path
                    style=\"fill:#28B446;\"
                    d=\"M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
            c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
            c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z\"
                  ></path>
                  <path
                    style=\"fill:#F14336;\"
                    d=\"M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
            c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
            C318.115,0,375.068,22.126,419.404,58.936z\"
                  ></path>
                </svg>
                <span style=\"color: #111; font-family: 'Inter', sans-serif;\">Sign-up with Google</span>
            </div>
          </a>";
          ?>

          <button class="button-submit">Sign Up</button>
          <p class="p">Already have a account? <a href="login.php"><span class="span">login</span></a></p>
          <div class="flex-row">


          </div>
        </form>

      </div>
      <div class="info-section">
        <!-- Content for the dark section - Placeholder for image -->
      </div>
    </div>
</body>

</html>

<?php
// Database configuration for XAMPP
$servername = "localhost";
$username = "root";    // Default XAMPP username
$password = "";        // Default XAMPP password (empty)
$dbname = "channel_zero";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $first_name = trim($_POST['first_name']);
  $last_name = trim($_POST['last_name']);
  $email = trim($_POST['email']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);

  // Basic validation
  if (empty($first_name) || empty($last_name) || empty($email) || empty($username) || empty($password)) {
    $error = "Please fill in all required fields.";
  } elseif ($password !== $confirm_password) {
    $error = "Passwords do not match.";
  } elseif (strlen($password) < 8) {
    $error = "Password must be at least 8 characters long.";
  } else {
    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $error = "An account with this email or username already exists.";
    } else {
      // Hash the password
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Insert new user
      $insert = $conn->prepare("INSERT INTO users 
              (first_name, last_name, email, username, password_hash, registration_date, status) 
              VALUES (?, ?, ?, ?, ?, NOW(), 'active')");
      $insert->bind_param("sssss", $first_name, $last_name, $email, $username, $hashed_password);

      if ($insert->execute()) {
        $success = "Account created successfully! You can now login.";
        // Clear form fields
        $first_name = $last_name = $email = $username = "";
      } else {
        $error = "Error creating account: " . $conn->error;
      }
      $insert->close();
    }
    $stmt->close();
  }
}
$conn->close();
?>
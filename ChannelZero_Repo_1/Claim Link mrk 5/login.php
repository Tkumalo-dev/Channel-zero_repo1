<?php
session_start();
$error = '';

// Include the Google API PHP Client Library
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables directly
$envFile = __DIR__ . '/google.env';
if (!file_exists($envFile)) {
    die('google.env file not found at: ' . $envFile);
}

// Read and parse the .env file
$envVars = parse_ini_file($envFile, false, INI_SCANNER_RAW);
if ($envVars === false) {
    die('Failed to parse google.env file');
}

// Set environment variables
$clientID = trim($envVars['GOOGLE_CLIENT_ID'] ?? '');
$clientSecret = trim($envVars['GOOGLE_CLIENT_SECRET'] ?? '');
$redirectUri = trim($envVars['GOOGLE_REDIRECT_URI'] ?? '');

if (empty($clientID) || empty($clientSecret) || empty($redirectUri)) {
    die('Google OAuth credentials are not properly set in the google.env file. Please check the file contents.');
}

// Initialize Google Client
$client = new Google\Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->setIncludeGrantedScopes(true);
$client->setPrompt('select_account consent');

// Set the scopes
$client->setScopes([
    'https://www.googleapis.com/auth/userinfo.email',
    'https://www.googleapis.com/auth/userinfo.profile'
]);

// Create the Google Sign-in URL
$authUrl = $client->createAuthUrl();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard(Lutho_Version).php');
    exit();
}

require 'db_connect.php';

// Initialize variables
$error = '';
$username = '';
$login_attempts = $_SESSION['login_attempts'] ?? 0;

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } elseif ($login_attempts >= 5) {
        $error = 'Too many login attempts. Please try again later.';
    } else {
        // Database authentication with prepared statement
        $stmt = $conn->prepare("SELECT user_id, username, password_hash, status FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password_hash'])) {
                // Check account status
                if ($user['status'] !== 'active') {
                    $error = 'Account is not active. Please contact support.';
                } else {
                    // Successful login
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    
                    // Reset login attempts
                    unset($_SESSION['login_attempts']);
                    
                    // Update last login
                    $update_stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
                    $update_stmt->bind_param("i", $user['user_id']);
                    $update_stmt->execute();
                    
                    // Regenerate session ID for security
                    session_regenerate_id(true);
                    
                    header('Location: dashboard(Lutho_Version).php');
                    exit();
                }
            } else {
                $error = 'Invalid username or password';
                $_SESSION['login_attempts'] = $login_attempts + 1;
            }
        } else {
            $error = 'Invalid username or password';
            $_SESSION['login_attempts'] = $login_attempts + 1;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Channel Zero</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h2>Welcome Back!</h2>
            
            <?php if (isset($_GET['registered'])): ?>
                <div class="success-message">Registration successful! Please login.</div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" 
                           value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit">Login</button>
            </form>
            
            <p class="register-text">
                Don't have an account? <a href="signup.php">Sign up here</a>
            </p>
            
            <p class="register-text">
                Forgot your password? <a href="forgot_password.php">Reset it here</a>
            </p>
            
            <div class="social-icons">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg" alt="Google">
            </div>
        </div>
        
        <div class="right-section">
            <img src="Other 03.png" alt="Channel Zero Illustration">
        </div>
    </div>
</body>
</html>
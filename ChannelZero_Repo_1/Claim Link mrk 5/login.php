<?php
session_start();

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Channel Zero</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .left-section {
            flex: 1;
            padding: 40px;
        }
        
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }
        
        .right-section img {
            max-width: 80%;
            height: auto;
        }
        
        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 28px;
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }
        
        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input:focus {
            border-color: #6e8efb;
            outline: none;
        }
        
        button {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        
        button:hover {
            opacity: 0.9;
        }
        
        .error-message {
            color: #e74c3c;
            background: #fdecea;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .success-message {
            color: #2ecc71;
            background: #e8f8f0;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .register-text {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        
        .register-text a {
            color: #6e8efb;
            text-decoration: none;
            font-weight: 500;
        }
        
        .register-text a:hover {
            text-decoration: underline;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .social-icons img {
            width: 24px;
            height: 24px;
            opacity: 0.6;
            transition: opacity 0.3s;
        }
        
        .social-icons img:hover {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .right-section {
                display: none;
            }
        }
    </style>
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
<?php
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        // Here you would typically validate against a database
        // For now, we'll just redirect to home page
        $_SESSION['username'] = $username;
        header('Location: home-page.html');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h2>Welcome Back!</h2>
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password">

                <button type="submit">Login</button>
            </form>
            <p class="register-text">
                Don't have an account?
                <a href="register.php">Register Now</a>
            </p>
            <div class="social-icons">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/google.svg" alt="Google">
            </div>
        </div>

        <div class="right-section">
            <img src="Other 03.png" alt="Laptop Photo">
        </div>
    </div>
</body>
</html> 
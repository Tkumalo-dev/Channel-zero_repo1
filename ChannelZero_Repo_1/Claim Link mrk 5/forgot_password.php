<?php
session_start();
require_once 'db_connect.php';
require_once 'mail_functions.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Please enter your email address';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address';
    } else {
        try {
            // Check if email exists in database
            $stmt = $conn->prepare("SELECT user_id, username FROM users WHERE email = ?");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("s", $email);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Generate a unique token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Store the token in the database
                $update_stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
                if (!$update_stmt) {
                    throw new Exception("Prepare update failed: " . $conn->error);
                }

                $update_stmt->bind_param("sss", $token, $expires, $email);

                if ($update_stmt->execute()) {
                    // Generate the reset link
                    $reset_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;

                    // Send the reset email
                    if (sendPasswordResetEmail($email, $reset_link)) {
                        $success = "Password reset instructions have been sent to your email address.";
                    } else {
                        throw new Exception("Failed to send reset email. Please try again later.");
                    }
                } else {
                    throw new Exception("Update failed: " . $update_stmt->error);
                }
                $update_stmt->close();
            } else {
                $error = "No account found with that email address";
            }
            $stmt->close();
        } catch (Exception $e) {
            $error = "An error occurred: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="reset_password.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="form-box">
                <h2 style="text-align: center; margin-bottom: 20px;">Reset Your Password</h2>

                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <form class="form" method="POST" action="">
                    <div class="flex-column">
                        <label>Email Address</label>
                    </div>
                    <div class="inputForm">
                        <svg height="20" viewBox="0 0 32 32" width="20" xmlns="http://www.w3.org/2000/svg">
                            <g id="Layer_3" data-name="Layer 3">
                                <path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path>
                            </g>
                        </svg>
                        <input type="email" name="email" class="input" placeholder="Enter your email address" required />
                    </div>

                    <button type="submit" class="button-submit">Send Reset Link</button>

                    <p class="p">Remember your password? <a href="login.php"><span class="span">Login here</span></a></p>
                </form>
            </div>
        </div>
        <div class="info-section">
            <!-- Content for the dark section -->
        </div>
    </div>
</body>

</html>
<?php
session_start();
require_once 'db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';
$success = '';
$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: forgot_password.php');
    exit;
}

try {
    // Verify token
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE reset_token = ? AND reset_token_expires > NOW()");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $token);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "Invalid or expired reset token. Please request a new password reset.";
    } else {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');

            if (empty($password)) {
                $error = "Password is required";
            } elseif (strlen($password) < 8) {
                $error = "Password must be at least 8 characters long";
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";
            } else {
                // Hash the new password
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Update the password and clear the reset token
                $update_stmt = $conn->prepare("UPDATE users SET password_hash = ?, reset_token = NULL, reset_token_expires = NULL WHERE user_id = ?");
                if (!$update_stmt) {
                    throw new Exception("Prepare update failed: " . $conn->error);
                }

                $update_stmt->bind_param("si", $password_hash, $user_id);

                if ($update_stmt->execute()) {
                    $success = "Your password has been reset successfully. You can now login with your new password.";
                } else {
                    throw new Exception("Update failed: " . $update_stmt->error);
                }
                $update_stmt->close();
            }
        }
    }
    $stmt->close();
} catch (Exception $e) {
    $error = "An error occurred: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="reset_password.css">
</head>

<body>
    <div class="container"style="text-align: center; margin-bottom: 20px;>
        <div class="form-container">
            <div class="form-box">
                <h2 ">Reset Your Password</h2>

                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>

                <?php if (empty($error) && empty($success)): ?>
                    <form class="form" method="POST" action="">
                        <div class="flex-column">
                            <label>New Password</label>
                        </div>
                        <div class="inputForm">
                            <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                                <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                            </svg>
                            <input type="password" name="password" class="input" placeholder="Enter new password" required />
                        </div>

                        <div class="flex-column">
                            <label>Confirm New Password</label>
                        </div>
                        <div class="inputForm">
                            <svg height="20" viewBox="-64 0 512 512" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path>
                                <path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path>
                            </svg>
                            <input type="password" name="confirm_password" class="input" placeholder="Confirm new password" required />
                        </div>

                        <button type="submit" class="button-submit">Reset Password</button>
                    </form>
                <?php endif; ?>

                <p class="p">Remember your password? <a href="login.php"><span class="span">Login here</span></a></p>
            </div>
        </div>
    </div>
</body>

</html>
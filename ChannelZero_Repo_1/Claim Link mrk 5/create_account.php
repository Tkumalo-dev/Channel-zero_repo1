<?php
session_start();
require_once 'db_connect.php';

// Check if it's an AJAX request
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($is_ajax) {
    header('Content-Type: application/json');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($is_ajax) {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
    } else {
        $_SESSION['error'] = 'Method not allowed';
        header('Location: signup.php');
    }
    exit();
}

// Get form data
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validate input
$errors = [];

if (empty($first_name)) {
    $errors['first_name'] = 'First name is required';
}

if (empty($last_name)) {
    $errors['last_name'] = 'Last name is required';
}

if (empty($username)) {
    $errors['username'] = 'Username is required';
}

if (empty($email)) {
    $errors['email'] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
}

if (empty($password)) {
    $errors['password'] = 'Password is required';
} elseif (strlen($password) < 8) {
    $errors['password'] = 'Password must be at least 8 characters long';
}

if ($password !== $confirm_password) {
    $errors['confirm_password'] = 'Passwords do not match';
}

// Check if username or email already exists
if (empty($errors)) {
    $check_stmt = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
    if (!$check_stmt) {
        if ($is_ajax) {
            http_response_code(500);
            echo json_encode(['error' => 'Database error: ' . $conn->error]);
        } else {
            $_SESSION['error'] = 'Database error: ' . $conn->error;
            header('Location: signup.php');
        }
        exit();
    }

    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['username'] === $username) {
                $errors['username'] = 'Username already exists';
            }
            if ($row['email'] === $email) {
                $errors['email'] = 'Email already exists';
            }
        }
    }
    $check_stmt->close();
}

if (!empty($errors)) {
    if ($is_ajax) {
        http_response_code(400);
        echo json_encode(['errors' => $errors]);
    } else {
        $_SESSION['error'] = implode(', ', $errors);
        header('Location: signup.php');
    }
    exit();
}

// Hash password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$insert_stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password_hash, status, registration_date) VALUES (?, ?, ?, ?, ?, 'active', NOW())");
if (!$insert_stmt) {
    if ($is_ajax) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Database error: ' . $conn->error
        ]);
    } else {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
        header('Location: signup.php');
    }
    exit();
}

$insert_stmt->bind_param("sssss", $first_name, $last_name, $username, $email, $password_hash);

if ($insert_stmt->execute()) {
    if ($is_ajax) {
        echo json_encode([
            'success' => true,
            'message' => 'Account created successfully'
        ]);
    } else {
        $_SESSION['success'] = 'Account created successfully';
        header('Location: login.php');
    }
} else {
    if ($is_ajax) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to create account: ' . $insert_stmt->error
        ]);
    } else {
        $_SESSION['error'] = 'Failed to create account: ' . $insert_stmt->error;
        header('Location: signup.php');
    }
}

$insert_stmt->close();
$conn->close();

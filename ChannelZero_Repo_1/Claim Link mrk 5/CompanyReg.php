<?php
session_start();
require 'db_connect.php'; // Use a centralized connection file

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $company_name = clean_input($_POST['company_name'] ?? '');
    $tax_id = clean_input($_POST['tax_id'] ?? '');
    $registration_number = clean_input($_POST['registration_number'] ?? '');
    $contact_person = clean_input($_POST['contact_person'] ?? '');
    $company_email = filter_input(INPUT_POST, 'company_email', FILTER_SANITIZE_EMAIL);
    $company_phone = clean_input($_POST['company_phone'] ?? '');
    $company_address = clean_input($_POST['company_address'] ?? '');
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate required fields
    if (empty($company_name)) $errors['company_name'] = "Company name is required";
    if (empty($tax_id)) $errors['tax_id'] = "Tax ID is required";
    if (empty($registration_number)) $errors['registration_number'] = "Registration number is required";
    if (empty($contact_person)) $errors['contact_person'] = "Contact person is required";
    if (!filter_var($company_email, FILTER_VALIDATE_EMAIL)) $errors['company_email'] = "Valid email is required";
    if (empty($company_phone)) $errors['company_phone'] = "Phone number is required";
    if (empty($company_address)) $errors['company_address'] = "Address is required";
    if (empty($username)) $errors['username'] = "Username is required";
    if (strlen($password) < 8) $errors['password'] = "Password must be at least 8 characters";
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $password)) {
        $errors['password'] = "Password must include uppercase, lowercase, number, and special character";
    }
    if ($password !== $confirm_password) $errors['confirm_password'] = "Passwords do not match";

    // Check for existing username or email
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT company_id FROM companies WHERE username = ? OR company_email = ?");
        $stmt->bind_param("ss", $username, $company_email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $errors['general'] = "Username or email already exists";
        }
        $stmt->close();
    }

    // Insert if no errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO companies (
            company_name, tax_id, registration_number, contact_person,
            company_email, company_phone, company_address, username, password_hash
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "sssssssss",
            $company_name, $tax_id, $registration_number, $contact_person,
            $company_email, $company_phone, $company_address, $username, $hashed_password
        );

        if ($stmt->execute()) {
            $success = "Company registered successfully!";
            $_SESSION['registration_success'] = true;
            // Clear form
            $company_name = $tax_id = $registration_number = $contact_person = 
            $company_email = $company_phone = $company_address = $username = '';
        } else {
            $errors['general'] = "Registration failed: " . $conn->error;
        }
        $stmt->close();
    }
}

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Registration</title>
    <link rel="stylesheet" href="companyReg.css">
</head>
<body>
    <h2>Company Registration</h2>

    <?php if (!empty($errors['general'])): ?>
        <div class="error-message"><?= $errors['general'] ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success-message"><?= $success ?></div>
    <?php endif; ?>

<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
    <!-- Company Details -->
    <label for="company_name">Company Name:</label>
    <input type="text" name="company_name" id="company_name" 
           value="<?= htmlspecialchars($company_name ?? '') ?>" required>
    <?php if (!empty($errors['company_name'])): ?>
        <span class="error"><?= $errors['company_name'] ?></span>
    <?php endif; ?>

    <label for="tax_id">Tax ID:</label>
    <input type="text" name="tax_id" id="tax_id" 
           value="<?= htmlspecialchars($tax_id ?? '') ?>" required>
    <?php if (!empty($errors['tax_id'])): ?>
        <span class="error"><?= $errors['tax_id'] ?></span>
    <?php endif; ?>

    <label for="registration_number">Registration Number:</label>
    <input type="text" name="registration_number" id="registration_number" 
           value="<?= htmlspecialchars($registration_number ?? '') ?>" required>
    <?php if (!empty($errors['registration_number'])): ?>
        <span class="error"><?= $errors['registration_number'] ?></span>
    <?php endif; ?>

    <label for="contact_person">Contact Person:</label>
    <input type="text" name="contact_person" id="contact_person" 
           value="<?= htmlspecialchars($contact_person ?? '') ?>" required>
    <?php if (!empty($errors['contact_person'])): ?>
        <span class="error"><?= $errors['contact_person'] ?></span>
    <?php endif; ?>

    <label for="company_email">Company Email:</label>
    <input type="email" name="company_email" id="company_email" 
           value="<?= htmlspecialchars($company_email ?? '') ?>" required>
    <?php if (!empty($errors['company_email'])): ?>
        <span class="error"><?= $errors['company_email'] ?></span>
    <?php endif; ?>

    <label for="company_phone">Phone Number:</label>
    <input type="tel" name="company_phone" id="company_phone" 
           value="<?= htmlspecialchars($company_phone ?? '') ?>" required>
    <?php if (!empty($errors['company_phone'])): ?>
        <span class="error"><?= $errors['company_phone'] ?></span>
    <?php endif; ?>

    <label for="company_address">Address:</label>
    <textarea name="company_address" id="company_address" required><?= 
        htmlspecialchars($company_address ?? '') 
    ?></textarea>
    <?php if (!empty($errors['company_address'])): ?>
        <span class="error"><?= $errors['company_address'] ?></span>
    <?php endif; ?>

    <!-- Authentication -->
    <h3>Authentication & Security</h3>

    <label for="username">Username:</label>
    <input type="text" name="username" id="username" 
           value="<?= htmlspecialchars($username ?? '') ?>" required>
    <?php if (!empty($errors['username'])): ?>
        <span class="error"><?= $errors['username'] ?></span>
    <?php endif; ?>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    <?php if (!empty($errors['password'])): ?>
        <span class="error"><?= $errors['password'] ?></span>
    <?php endif; ?>
    <small>Password must be at least 8 characters long, and include uppercase, lowercase, numbers, and symbols.</small>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" required>
    <?php if (!empty($errors['confirm_password'])): ?>
        <span class="error"><?= $errors['confirm_password'] ?></span>
    <?php endif; ?>

    <button type="submit">Register Company</button>
</form>

    <script src="companyReg.js"></script>
</body>
</html>
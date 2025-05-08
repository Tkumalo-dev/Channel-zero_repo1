<?php
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get all form data
    $firstName = $_POST['first-name'] ?? '';
    $middleName = $_POST['middle-name'] ?? '';
    $lastName = $_POST['last-name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $idNumber = $_POST['id-number'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $kinName = $_POST['kinName'] ?? '';
    $kinRelationship = $_POST['kinRelationship'] ?? '';
    $kinPhone = $_POST['kinPhone'] ?? '';

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($username) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all required fields';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long';
    } else {
        // Here you would typically:
        // 1. Hash the password
        // 2. Store user data in database
        // 3. Send confirmation email
        // For now, we'll just redirect to login page
        $success = 'Registration successful! Please login.';
        header('Location: login.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="Register1.css">
    <link rel="stylesheet" href="Register.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h2>Registration Form</h2>
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            <form class="registration-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Basic Personal Information -->
                <h3>Basic Personal Information</h3>
                
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" placeholder="Enter first name" required 
                       value="<?php echo isset($_POST['first-name']) ? htmlspecialchars($_POST['first-name']) : ''; ?>">
                
                <label for="middle-name">Middle Name:</label>
                <input type="text" id="middle-name" name="middle-name" placeholder="Enter middle name"
                       value="<?php echo isset($_POST['middle-name']) ? htmlspecialchars($_POST['middle-name']) : ''; ?>">
                
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" placeholder="Enter last name" required
                       value="<?php echo isset($_POST['last-name']) ? htmlspecialchars($_POST['last-name']) : ''; ?>">
                
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>">
                
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                </select>
                
                <label for="nationality">Nationality/Citizenship:</label>
                <input type="text" id="nationality" name="nationality" placeholder="Enter nationality"
                       value="<?php echo isset($_POST['nationality']) ? htmlspecialchars($_POST['nationality']) : ''; ?>">
                
                <label for="id-number">Government ID Number:</label>
                <input type="text" id="id-number" name="id-number" placeholder="Enter ID number"
                       value="<?php echo isset($_POST['id-number']) ? htmlspecialchars($_POST['id-number']) : ''; ?>">
                
                <!-- Contact Details -->
                <h3>Contact Details</h3>
                
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                
                <!-- Next of Kin Information -->
                <h3>Next of Kin Details</h3>
                <label for="kinName">Full Name:</label>
                <input type="text" id="kinName" name="kinName" placeholder="Next of kin's full name"
                       value="<?php echo isset($_POST['kinName']) ? htmlspecialchars($_POST['kinName']) : ''; ?>">
                
                <label for="kinRelationship">Relationship:</label>
                <input type="text" id="kinRelationship" name="kinRelationship" placeholder="E.g. Mother, Father, Spouse"
                       value="<?php echo isset($_POST['kinRelationship']) ? htmlspecialchars($_POST['kinRelationship']) : ''; ?>">
                
                <label for="kinPhone">Phone Number:</label>
                <input type="tel" id="kinPhone" name="kinPhone" placeholder="Next of kin's phone number"
                       value="<?php echo isset($_POST['kinPhone']) ? htmlspecialchars($_POST['kinPhone']) : ''; ?>">
                
                <!-- Authentication & Security -->
                <h3>Authentication & Security</h3>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Choose a username" required
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Create a strong password" required>
                <small>Password must contain at least 8 characters, including uppercase, lowercase, numbers and special characters</small>
                
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter your password" required>
                
                <button type="submit">Register</button>
            </form>
            <p class="login-text">
                Already have an account?
                <a href="login.php">Login Here</a>
            </p>
        </div>
    </div>
</body>
</html> 
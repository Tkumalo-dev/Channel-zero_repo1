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
        $success = 'Registration successful! Redirecting to login...';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="Register.css">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Page</title>
  </head>
  <body>
    <div class="container">
      <div class="left-section">
        <h2>Registration Form</h2>
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
            <script>
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 4000); // Redirect after 4 seconds
            </script>
        <?php endif; ?>
        <form class="registration-form">
          <!-- Basic Personal Information -->
          <h3>Basic Personal Information</h3>

          <label for="first-name">First Name:</label>
          <input
            type="text"
            id="first-name"
            placeholder="Enter first name"
            required
          />

          <label for="middle-name">Middle Name:</label>
          <input type="text" id="middle-name" placeholder="Enter middle name" />

          <label for="last-name">Last Name:</label>
          <input
            type="text"
            id="last-name"
            placeholder="Enter last name"
            required
          />

          <label for="dob">Date of Birth:</label>
          <input type="date" id="dob" />

          <label for="gender">Gender:</label>
          <select id="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>

          <label for="nationality">Nationality/Citizenship:</label>
          <input type="text" id="nationality" placeholder="Enter nationality" />

          <label for="id-number">Government ID Number:</label>
          <input type="text" id="id-number" placeholder="Enter ID number" />

          <!-- Contact Details -->
          <h3>Contact Details</h3>

          <label for="email">Email Address:</label>
          <input type="email" id="email" placeholder="Enter email" />

          <label for="mobile">Mobile Number:</label>
          <input type="tel" id="mobile" placeholder="Enter mobile number" />

          <label for="street">Street Address:</label>
          <input type="text" id="street" placeholder="Enter street address" />

          <label for="city">City:</label>
          <input type="text" id="city" placeholder="Enter city" />

          <label for="province">Province:</label>
          <select id="province">
            <option value="">Select Province</option>
            <option value="EC">Eastern Cape</option>
            <option value="FS">Free State</option>
            <option value="GP">Gauteng</option>
            <option value="KZN">KwaZulu-Natal</option>
            <option value="LP">Limpopo</option>
            <option value="MP">Mpumalanga</option>
            <option value="NC">Northern Cape</option>
            <option value="NW">North West</option>
            <option value="WC">Western Cape</option>
          </select>

          <label for="postal-code">Postal Code:</label>
          <input type="text" id="postal-code" placeholder="Enter postal code" />

          <label for="country">Country:</label>
          <input type="text" id="country" placeholder="Enter country" />

          <label for="alternate-contact">Alternate Contact (optional):</label>
          <input
            type="text"
            id="alternate-contact"
            placeholder="For emergency contacts"
          />

          <!-- Next of Kin Information -->
          <h3>Next of Kin Details</h3>
          <label for="kinName">Full Name:</label>
          <input
            type="text"
            id="kinName"
            placeholder="Next of kin's full name"
          />

          <label for="kinRelationship">Relationship:</label>
          <input
            type="text"
            id="kinRelationship"
            placeholder="E.g. Mother, Father, Spouse"
          />

          <label for="kinPhone">Phone Number:</label>
          <input
            type="tel"
            id="kinPhone"
            placeholder="Next of kin's phone number"
          />

          <!-- Authentication & Security -->
          <h3>Authentication & Security</h3>

          <label for="username">Username:</label>
          <input
            type="text" id="username" placeholder="Choose a username"required />

          <label for="password">Password:</label>
          <input
            type="password"
            id="password"
            placeholder="Create a strong password"
            required
          />
          <small
            >Password must contain at least 8 characters, including uppercase,
            lowercase, numbers and special characters</small
          >

          <label for="confirm-password">Confirm Password:</label>
          <input
            type="password"
            id="confirm-password"
            placeholder="Re-enter your password"
            required
          />

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

<?php
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first-name'] ?? '';
    $middleName = $_POST['middle-name'] ?? '';
    $lastName = $_POST['last-name'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $idNumber = $_POST['id-number'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $street = $_POST['street'] ?? '';
    $city = $_POST['city'] ?? '';
    $province = $_POST['province'] ?? '';
    $postalCode = $_POST['postal-code'] ?? '';
    $country = $_POST['country'] ?? '';
    $alternateContact = $_POST['alternate-contact'] ?? '';
    $kinName = $_POST['kinName'] ?? '';
    $kinRelationship = $_POST['kinRelationship'] ?? '';
    $kinPhone = $_POST['kinPhone'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    if (empty($firstName) || empty($lastName) || empty($username) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all required fields';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long';
    } else {
        // Insert into registration_details
        $conn = new mysqli("localhost", "root", "", "channel_zero");

        if ($conn->connect_error) {
            $error = "Connection failed: " . $conn->connect_error;
        } else {
            $stmt = $conn->prepare("INSERT INTO registration_details (
                username, first_name, middle_name, last_name, dob, gender, nationality, id_number,
                email, mobile, street, city, province, postal_code, country, alternate_contact,
                kin_name, kin_relationship, kin_phone
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("sssssssssssssssssss",
                $username, $firstName, $middleName, $lastName, $dob, $gender, $nationality, $idNumber,
                $email, $mobile, $street, $city, $province, $postalCode, $country, $alternateContact,
                $kinName, $kinRelationship, $kinPhone
            );

            if ($stmt->execute()) {
                $success = 'Registration successful! Redirecting to login...';
            } else {
                $error = 'Database error: ' . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Register.css">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Registration Page</title>
</head>
<body>
<div class="container">
    <div class="left-section">
        <h2>Registration Form</h2>

        <?php if ($error): ?>
            <div style="color: red;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div style="color: green;"><?php echo $success; ?></div>
            <script>
                setTimeout(function () {
                    window.location.href = 'login.php';
                }, 4000);
            </script>
        <?php endif; ?>

        <form class="registration-form" method="POST" action="">
            <!-- Basic Info -->
            <h3>Basic Personal Information</h3>

            <label>First Name:</label>
            <input type="text" name="first-name" required />

            <label>Middle Name:</label>
            <input type="text" name="middle-name" />

            <label>Last Name:</label>
            <input type="text" name="last-name" required />

            <label>Date of Birth:</label>
            <input type="date" name="dob" />

            <label>Gender:</label>
            <select name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label>Nationality:</label>
            <input type="text" name="nationality" />

            <label>ID Number:</label>
            <input type="text" name="id-number" />

            <!-- Contact Details -->
            <h3>Contact Details</h3>

            <label>Email Address:</label>
            <input type="email" name="email" />

            <label>Mobile Number:</label>
            <input type="tel" name="mobile" />

            <label>Street Address:</label>
            <input type="text" name="street" />

            <label>City:</label>
            <input type="text" name="city" />

            <label>Province:</label>
            <select name="province">
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

            <label>Postal Code:</label>
            <input type="text" name="postal-code" />

            <label>Country:</label>
            <input type="text" name="country" />

            <label>Alternate Contact (optional):</label>
            <input type="text" name="alternate-contact" />

            <!-- Next of Kin -->
            <h3>Next of Kin Details</h3>

            <label>Full Name:</label>
            <input type="text" name="kinName" />

            <label>Relationship:</label>
            <input type="text" name="kinRelationship" />

            <label>Phone Number:</label>
            <input type="tel" name="kinPhone" />

            <!-- Security -->
            <h3>Authentication & Security</h3>

            <label>Username:</label>
            <input type="text" name="username" required />

            <label>Password:</label>
            <input type="password" name="password" required />

            <label>Confirm Password:</label>
            <input type="password" name="confirm-password" required />

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
</div>
</body>
</html>
